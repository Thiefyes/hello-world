class App extends React.Component {
  state = {
    pages: [],
    title: '',
    content: '',
    slug: '',
    editingId: null,
    loggedIn: false,
    users: [],
    username: '',
    password: ''
  };

  componentDidMount() {
    fetch('../backend/login.php')
      .then(res => res.json())
      .then(res => {
        if (res.logged_in) {
          this.setState({ loggedIn: true }, () => {
            this.loadPages();
            this.loadUsers();
          });
        }
      });
  }

  loadPages = () => {
    fetch('../backend/api.php')
      .then(res => res.json())
      .then(pages => this.setState({ pages }));
  };

  loadUsers = () => {
    fetch('../backend/users.php')
      .then(res => res.json())
      .then(users => this.setState({ users }));
  };

  login = () => {
    fetch('../backend/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ username: this.state.username, password: this.state.password })
    }).then(res => {
      if (res.ok) {
        this.setState({ loggedIn: true }, this.loadPages);
      } else {
        alert('Login failed');
      }
    });
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
    if (!this.state.loggedIn) {
      return (
        <div>
          <h1>Login</h1>
          <input
            placeholder="Username"
            value={this.state.username}
            onChange={e => this.setState({ username: e.target.value })}
          />
          <br />
          <input
            type="password"
            placeholder="Password"
            value={this.state.password}
            onChange={e => this.setState({ password: e.target.value })}
          />
          <br />
          <button onClick={this.login}>Login</button>
        </div>
      );
    }
    return (
      <div>
        <h1>CMS Admin</h1>
        <input
          placeholder="Title"
          value={this.state.title}
          onChange={e => {
            const title = e.target.value;
            this.setState({ title });
            fetch(`../backend/seo.php?title=${encodeURIComponent(title)}`)
              .then(res => res.json())
              .then(data => this.setState({ slug: data.slug }));
          }}
        />
        <br />
        <input
          placeholder="Slug"
          value={this.state.slug}
          readOnly
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
        <h2>Users</h2>
        <ul>
          {this.state.users.map(u => (
            <li key={u.username}>{u.username}</li>
          ))}
        </ul>
      </div>
    );
  }
}

ReactDOM.render(<App />, document.getElementById('root'));
