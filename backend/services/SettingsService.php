<?php
class SettingsService {
    private string $file;

    public function __construct(string $file) {
        $this->file = $file;
    }

    public function get(): array {
        return include $this->file;
    }
}
