<?php
class AuthService {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function checkCredentials(string $username, string $password): bool {
        $stmt = $this->pdo->prepare('SELECT password_hash FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        return $row && password_verify($password, $row['password_hash']);
    }
}
