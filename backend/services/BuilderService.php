<?php
class BuilderService {
    public function buildTemplate(string $title, string $content): string {
        return "<article><header><h1>$title</h1></header><div>$content</div></article>";
    }
}
