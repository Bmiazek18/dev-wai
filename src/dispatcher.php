<?php

const REDIRECT_PREFIX = 'redirect:';

class Dispatcher
{
    private $routing;

    public function __construct(array $routing)
    {
        $this->routing = $routing;
    }

    public function dispatch(string $action_url)
    {
        $action_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset($this->routing[$action_url])) {
            http_response_code(404);
            echo "404 - Brak routingu dla: $action_url";
            return;
        }

        $route = $this->routing[$action_url];
        $controller_name = $route['controller'];
        $action_name = $route['action'];

        // Autoload kontrolera
        if (file_exists("controllers/$controller_name.php")) {
            require_once "controllers/$controller_name.php";
        }

        $controller = new $controller_name();
        $model = [];

        $view_name = $controller->$action_name($model);
        if (is_array($view_name) && isset($view_name['raw'])) {
            // np. AJAX zwraca ['raw' => '<div>...</div>']
            header('Content-Type: text/html; charset=UTF-8');
            echo $view_name['raw'];
            return;
        }
        $this->buildResponse($view_name, $model);
    }

    private function buildResponse(string $view, array $model)
    {
        if (strpos($view, REDIRECT_PREFIX) === 0) {
            $url = substr($view, strlen(REDIRECT_PREFIX));
            header('Location: ' . $url);
            exit();
        } else {
            $this->render($view, $model);
        }
    }

    private function render(string $view_name, array $model)
    {
        extract($model);
        include 'views/partials/header.php';
        include 'views/' . $view_name . '.php';
    }
}
