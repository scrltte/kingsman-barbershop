<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $route, array $params): void {
        // Превращаем параметры вида {id} в регулярное выражение
        $route = preg_replace('/\\{([a-z_]+)\\}/', '(?P<$1>[a-z0-9_-]+)', $route);
        $route = '#^' . $route . '$#i';
        $this->routes[$route] = $params;
    }

    public function dispatch(string $uri): void {
        // Убираем GET-параметры из URI
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $uri, $matches)) {
                $controllerName = 'App\\Controllers\\' . $params['controller'];
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $action = $params['action'];

                    if (method_exists($controller, $action)) {
                        // Извлекаем именованные параметры из URL
                        $actionParams = array_filter($matches, fn($key) => !is_int($key), ARRAY_FILTER_USE_KEY);
                        $controller->$action($actionParams);
                        return;
                    }
                }
            }
        }

        // Если маршрут не найден
        http_response_code(404);
        echo "<h1>404 Страница не найдена</h1>";
    }
}