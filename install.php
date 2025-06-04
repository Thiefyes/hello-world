<?php
if (file_exists(__DIR__ . '/backend/config.php')) {
    echo 'CMS already installed.';
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? 'localhost';
    $dbname = $_POST['dbname'] ?? 'cms';
    $user = $_POST['user'] ?? 'cms_user';
    $password = $_POST['password'] ?? '';

    $adminUser = $_POST['admin_user'] ?? 'admin';
    $adminPass = $_POST['admin_password'] ?? 'password';

    $config = [
        'host' => $host,
        'dbname' => $dbname,
        'user' => $user,
        'password' => $password,
        'admin_user' => $adminUser,
        'admin_password' => $adminPass,
    ];

    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
        $pdo->exec("USE `$dbname`");
        $pdo->exec("CREATE TABLE IF NOT EXISTS pages (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, content TEXT NOT NULL)");
        file_put_contents(__DIR__ . '/backend/config.php', "<?php\nreturn " . var_export($config, true) . ";\n");
        echo 'Installation successful. Please delete install.php.';
        exit;
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>CMS Install</title></head>
<body>
<h1>CMS Installation</h1>
<?php if ($error): ?>
  <p style="color:red;">Error: <?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
<?php endif; ?>
<form method="post">
  <input name="host" placeholder="DB Host" value="localhost" required><br>
  <input name="dbname" placeholder="DB Name" value="cms" required><br>
  <input name="user" placeholder="DB User" value="cms_user" required><br>
  <input name="password" placeholder="DB Password" required type="password"><br>
  <input name="admin_user" placeholder="Admin Username" value="admin" required><br>
  <input name="admin_password" placeholder="Admin Password" type="password" required><br>
  <button type="submit">Install</button>
</form>
</body>
</html>
