<?php
if (!file_exists(__DIR__ . '/backend/config.php')) {
    header('Location: install.php');
    exit;
}
?><!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>CMS Installed</title></head>
<body>
<h1>CMS Installed</h1>
<p>The CMS is successfully installed.</p>
<p><a href="/admin/">Go to admin panel</a></p>
</body>
</html>
