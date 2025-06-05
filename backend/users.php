<?php
header('Content-Type: application/json');
require __DIR__ . '/db.php';

$stmt = $pdo->query('SELECT username FROM users ORDER BY id');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
