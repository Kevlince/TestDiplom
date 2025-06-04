<?php

namespace App\Core;

class Router {
    private $routes = [];

    public function add(string $method, string $path, callable $handler): void {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void {
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes[$method] as $route => $handler) {
            if ($route === $path) {
                call_user_func($handler);
                return;
            }
        }

        http_response_code(404);
        echo 'Not Found';
    }

    public function group(string $prefix, callable $callback): void {
        $router = new self();
        $callback($router);

        foreach ($router->routes as $method => $routes) {
            foreach ($routes as $path => $handler) {
                $this->routes[$method][$prefix . $path] = $handler;
            }
        }
    }
}