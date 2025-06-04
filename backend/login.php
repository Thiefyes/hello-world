<?php
session_start();
header('Content-Type: application/json');

$config = include __DIR__ . '/config.php';
$adminUser = $config['admin_user'] ?? 'admin';
$adminPass = $config['admin_password'] ?? 'password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (($data['username'] ?? '') === $adminUser && ($data['password'] ?? '') === $adminPass) {
        $_SESSION['logged_in'] = true;
        echo json_encode(['success' => true]);
    } else {
        http_response_code(401);
        echo json_encode(['success' => false]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['logged_in' => ($_SESSION['logged_in'] ?? false)]);
} else {
    http_response_code(405);
}
