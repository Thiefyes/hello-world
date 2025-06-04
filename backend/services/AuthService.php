<?php
class AuthService {
    private string $adminUser;
    private string $adminPass;

    public function __construct(array $config) {
        $this->adminUser = $config['admin_user'] ?? 'admin';
        $this->adminPass = $config['admin_password'] ?? 'password';
    }

    public function checkCredentials(string $username, string $password): bool {
        return $username === $this->adminUser && $password === $this->adminPass;
    }
}
