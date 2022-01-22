<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\routes;

use natoxCore\exception\NotFoundException;

class Router
{
    public $url;
    public array $routes = [];

    public function __construct($url)
    {
        $this->url = trim($url, '/');
    }

    public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);
    }

    public function post(string $path, string $action)
    {
        $this->routes['POST'][] = new Route($path, $action);
    }

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function resolve()
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if ($route->matches($this->url)) {
                return $route->execute();
            }
        }
        throw new NotFoundException();
    }
}