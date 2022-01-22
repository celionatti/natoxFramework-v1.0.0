<?php

declare(strict_types=1);

/**User: Celio Natti ** */

namespace natoxCore\routes;

use natoxCore\Application;

class Route
{
    public $path;
    public $action;

    public function __construct($path, $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    public function matches(string $url)
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        if (preg_match($pathToMatch, $url, $matches)) {
            $this->matches = $matches;
            return true;
        }
        return false;
    }

    public function execute()
    {
        /** @var \natoxCore\Controller $controller */
        $params = explode('@', $this->action);
        $controller = new $params[0]();
        Application::$app->controller = $controller;
        $controller->action = $params[1];
        $method = $params[1];

        foreach ($controller->getMiddlewares() as $middleware) {
            $middleware->execute();
        }

        return isset($this->matches[1]) ? $controller->$method($this->matches[1]) : $controller->$method();
    }
}