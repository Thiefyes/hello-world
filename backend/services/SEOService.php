<?php
class SEOService {
    public function meta(string $title): array {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
        return [
            'title' => $title,
            'slug' => trim($slug, '-')
        ];
    }
}
