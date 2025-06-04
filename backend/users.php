<?php
header('Content-Type: application/json');
$config = include __DIR__ . '/config.php';

$users = [
    ['username' => $config['admin_user']]
];

echo json_encode($users);
