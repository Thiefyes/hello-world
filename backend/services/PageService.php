<?php
class PageService {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM pages ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function get(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM pages WHERE id = ?');
        $stmt->execute([$id]);
        $page = $stmt->fetch();
        return $page ?: null;
    }

    public function create(string $title, string $content): int {
        $stmt = $this->pdo->prepare('INSERT INTO pages (title, content) VALUES (?, ?)');
        $stmt->execute([$title, $content]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, string $title, string $content): void {
        $stmt = $this->pdo->prepare('UPDATE pages SET title = ?, content = ? WHERE id = ?');
        $stmt->execute([$title, $content, $id]);
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare('DELETE FROM pages WHERE id = ?');
        $stmt->execute([$id]);
    }
}
