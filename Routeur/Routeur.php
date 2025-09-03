<?php

/**
 * Routeur minimaliste.
 *
 * - Enregistre des routes GET/POST sous la forme "FQCN@method"
 * - Fait correspondre l’URI de la requête à une route (avec paramètres {param})
 * - Instancie le contrôleur et appelle la méthode correspondante
 */
class Router
{
    /**
     * Registre des routes.
     *
     *
     * @var array<string, array<string, string>>
     */
    private array $routes = [];

    /**
     * Enregistre une route HTTP GET.
     *
     * @param string $path   Chemin de route (ex. "/trajet/{id}")
     * @param string $action Action cible au format "FQCN@method"
     * @return void
     */
    public function get(string $path, string $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    /**
     * Enregistre une route HTTP POST.
     *
     * @param string $path   Chemin de route (ex. "/login")
     * @param string $action Action cible au format "FQCN@method"
     * @return void
     */
    public function post(string $path, string $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    /**
     * Enregistre une route (méthode interne).
     *
     * Enlève les slashs superflus
     * et mappe l’action sur la méthode HTTP.
     *
     * @param string $method Méthode HTTP ("GET"|"POST")
     * @param string $path   Chemin de route (ex. "/trajet/{id}")
     * @param string $action Action cible au format "FQCN@method"
     * @return void
     */
    private function addRoute(string $method, string $path, string $action): void
    {
        // Normaliser le chemin : toujours sans slash final sauf pour "/"
        $path = '/' . trim($path, '/');
        if ($path === '/index.php') {
            $path = '/';
        }
        $this->routes[$method][$path] = $action;
    }

    /**
     * Tente de faire correspondre l’URI de la requête à une route,
     * puis exécute l’action associée si trouvée.
     *
     * Règles :
     * - Retire le base path "/touche-pas-au-klaxon/public"
     * - Convertit les paramètres {param} en groupes capturants
     *
     * @return mixed|null Retour de l’action appelée (si la méthode du contrôleur retourne quelque chose), sinon null.
     */
    public function dispatch()
    {
        // Récupère l'URI demandée (sans la query string)
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Supprime le base path si nécessaire (chemin vers public)
        $basePath = '/touche-pas-au-klaxon/public';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Normaliser l'URI (ex. "" -> "/")
        $uri = '/' . trim($uri, '/');

        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] ?? [] as $path => $action) {
            // Convertit les {param} en regex capturante
            // Exemple: "/trajet/{id}" -> "#^/trajet/([0-9a-zA-Z_-]+)$#"
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([0-9a-zA-Z_-]+)', $path);
            $pattern = rtrim($pattern, '/'); // supprime le slash final
            if ($pattern === '') {
                $pattern = '/'; // pour la racine
            }
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // supprime la correspondance complète
                return $this->callAction($action, $matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
        return null;
    }

    /**
     * Instancie le contrôleur et appelle la méthode avec les paramètres.
     *
     * @param string              $action Chaîne "FQCN@method"
     * @param array<int, string>  $params Paramètres capturés depuis l’URI
     * @return mixed|null         Retour de la méthode du contrôleur (si elle retourne quelque chose), sinon null
     */
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

        // Appelle la méthode et retourne son résultat (si applicable)
        return call_user_func_array([$controllerInstance, $method], $params);
    }
}
