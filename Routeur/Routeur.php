<?php
class Router
{
    private array $routes = [];

    public function get(string $path, string $action)
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, string $action)
    {
        $this->addRoute('POST', $path, $action);
    }

    private function addRoute(string $method, string $path, string $action)
    {
        // Normaliser le chemin : toujours sans slash final sauf pour "/"
        $path = '/' . trim($path, '/');
        if ($path === '/index.php') $path = '/';
        $this->routes[$method][$path] = $action;
    }

    public function dispatch()
    {
        // Récupère l'URI demandée
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Supprime le base path si nécessaire (chemin vers public)
        $basePath = '/touche-pas-au-klaxon/public';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Normaliser l'URI
        $uri = '/' . trim($uri, '/');

        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] ?? [] as $path => $action) {
            // Convertit les {param} en regex
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([0-9a-zA-Z_-]+)', $path);
            $pattern = rtrim($pattern, '/'); // supprime le slash final
            if ($pattern === '') $pattern = '/'; // pour la racine
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // supprime la correspondance complète
                return $this->callAction($action, $matches);
            }
        }

        // Route non trouvée
        http_response_code(404);
        echo "404 Not Found";
}


    private function callAction(string $action, array $params)
    {
        [$controller, $method] = explode('@', $action);
        if (!class_exists($controller)) {
            http_response_code(500);
            echo "Controller '$controller' non trouvé";
            exit;
        }
        $controllerInstance = new $controller();
        if (!method_exists($controllerInstance, $method)) {
            http_response_code(500);
            echo "Méthode '$method' non trouvée dans le controller '$controller'";
            exit;
        }
        call_user_func_array([$controllerInstance, $method], $params);
    }
}
