<?php
header('Content-Type: application/json');
require __DIR__ . '/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM pages WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch());
        } else {
            $stmt = $pdo->query('SELECT * FROM pages ORDER BY id DESC');
            echo json_encode($stmt->fetchAll());
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare('INSERT INTO pages (title, content) VALUES (?, ?)');
        $stmt->execute([$data['title'], $data['content']]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
        break;
    case 'PUT':
        if (!$id) { http_response_code(400); exit; }
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare('UPDATE pages SET title = ?, content = ? WHERE id = ?');
        $stmt->execute([$data['title'], $data['content'], $id]);
        echo json_encode(['status' => 'ok']);
        break;
    case 'DELETE':
        if (!$id) { http_response_code(400); exit; }
        $stmt = $pdo->prepare('DELETE FROM pages WHERE id = ?');
        $stmt->execute([$id]);
        echo json_encode(['status' => 'ok']);
        break;
    default:
        http_response_code(405);
}
