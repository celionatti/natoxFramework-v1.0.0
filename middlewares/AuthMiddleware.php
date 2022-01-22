<?php

declare(strict_types=1);

/**User: Celio Natti** */

namespace natoxCore\middlewares;

use natoxCore\Application;
use natoxCore\exception\ForbiddenException;

/**
 * class AuthMiddleware
 * 
 * @author Celio Natti <Celionatti@gmail.com>
 * @package natoxCore\middlewares
 */

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * AuthMiddleware constructor
     * 
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
            throw new ForbiddenException();
        }
    }
}
