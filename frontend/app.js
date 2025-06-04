class App extends React.Component {
  state = { pages: [], title: '', content: '', editingId: null };

  componentDidMount() { this.loadPages(); }

  loadPages = () => {
    fetch('../backend/api.php')
      .then(res => res.json())
      .then(pages => this.setState({ pages }));
  };

  savePage = () => {
    const { title, content, editingId } = this.state;
    const method = editingId ? 'PUT' : 'POST';
    const url = '../backend/api.php' + (editingId ? `?id=${editingId}` : '');
    fetch(url, {
      method,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ title, content })
    }).then(() => {
      this.setState({ title: '', content: '', editingId: null });
      this.loadPages();
    });
  };

  editPage = (page) => this.setState({ title: page.title, content: page.content, editingId: page.id });

  deletePage = (id) => {
    fetch(`../backend/api.php?id=${id}`, { method: 'DELETE' })
      .then(() => this.loadPages());
  };

  render() {
    return (
      <div>
        <h1>CMS Admin</h1>
        <input
          placeholder="Title"
          value={this.state.title}
          onChange={e => this.setState({ title: e.target.value })}
        />
        <br />
        <textarea
          placeholder="Content"
          value={this.state.content}
          onChange={e => this.setState({ content: e.target.value })}
        />
        <br />
        <button onClick={this.savePage}>{this.state.editingId ? 'Update' : 'Create'} Page</button>
        <h2>Pages</h2>
        {this.state.pages.map(page => (
          <div key={page.id} className="page">
            <h3>{page.title}</h3>
            <div dangerouslySetInnerHTML={{ __html: page.content }} />
            <button onClick={() => this.editPage(page)}>Edit</button>
            <button onClick={() => this.deletePage(page.id)}>Delete</button>
          </div>
        ))}
      </div>
    );
  }
}

ReactDOM.render(<App />, document.getElementById('root'));
