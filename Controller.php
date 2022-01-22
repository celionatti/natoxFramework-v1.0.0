<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore;

use natoxCore\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';

    /**
     *
     * @var \natoxCore\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Get the value of middlewares
     *
     * @return  \natoxCore\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

}