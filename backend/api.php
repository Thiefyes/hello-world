<?php
header('Content-Type: application/json');
require __DIR__ . '/db.php';
require __DIR__ . '/services/PageService.php';

$pageService = new PageService($pdo);
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            echo json_encode($pageService->get($id));
        } else {
            echo json_encode($pageService->getAll());
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $newId = $pageService->create($data['title'], $data['content']);
        echo json_encode(['id' => $newId]);
        break;
    case 'PUT':
        if (!$id) { http_response_code(400); exit; }
        $data = json_decode(file_get_contents('php://input'), true);
        $pageService->update($id, $data['title'], $data['content']);
        echo json_encode(['status' => 'ok']);
        break;
    case 'DELETE':
        if (!$id) { http_response_code(400); exit; }
        $pageService->delete($id);
        echo json_encode(['status' => 'ok']);
        break;
    default:
        http_response_code(405);
}
