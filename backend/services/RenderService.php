<?php
class RenderService {
    private PageService $pages;

    public function __construct(PageService $pages) {
        $this->pages = $pages;
    }

    public function render(int $id): string {
        $page = $this->pages->get($id);
        if (!$page) {
            return 'Page not found';
        }
        return "<h1>" . htmlspecialchars($page['title']) . "</h1>\n" . $page['content'];
    }
}
