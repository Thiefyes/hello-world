<?php
header('Content-Type: application/json');
require __DIR__ . '/services/SEOService.php';

$title = $_GET['title'] ?? '';
$seo = new SEOService();

echo json_encode($seo->meta($title));
