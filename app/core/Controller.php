<?php
namespace App\Core;

abstract class Controller {
    protected function render(string $view, array $data = []): void {
        extract($data);
        $viewPath = __DIR__ . "/../views/{$view}.php";
        
        if (file_exists($viewPath)) {
            require_once __DIR__ . "/../views/layouts/header.php";
            require_once $viewPath;
            require_once __DIR__ . "/../views/layouts/footer.php";
        } else {
            die("Представление {$view} не найдено.");
        }
    }
}