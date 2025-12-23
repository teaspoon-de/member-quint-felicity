<?php

class Router
{
    private array $routes = [];

    public function get($pattern, $callback)
    {
        $this->routes['GET'][] = [$pattern, $callback];
    }

    public function post($pattern, $callback)
    {
        $this->routes['POST'][] = [$pattern, $callback];
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // 🔹 Slash-Normalisierung (außer Root)
        if ($path !== '/' && str_ends_with($path, '/')) {
            $normalized = rtrim($path, '/');
            http_response_code(301);
            header("Location: $normalized");
            exit;
        }

        if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
            if (!$this->validCsrfToken()) {
                http_response_code(403);
                echo "CSRF validation failed.";
                return;
            }
        }

        foreach ($this->routes[$method] ?? [] as [$pattern, $callback]) {
            $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern);

            if (preg_match("#^$regex$#", $path, $matches)) {
                array_shift($matches); // erste Gruppe entfernen
                return $this->execute($callback, $matches);
            }
        }

        http_response_code(404);
        echo "404 – Not found";
    }
    
    private function validCsrfToken() {
        if (!isset($_POST['csrf_token'], $_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
    }

    private function execute($callback, $params)
    {
        [$class, $method] = $callback;
        $controller = new $class();
        return call_user_func_array([$controller, $method], $params);
    }
}
