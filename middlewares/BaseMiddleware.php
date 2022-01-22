<?php

declare(strict_types=1);

/**User: Celio Natti** */

namespace natoxCore\middlewares;

/**
 * class BaseMiddleware
 * 
 * @author Celio Natti <Celionatti@gmail.com>
 * @package natoxCore\middlewares
 */

abstract class BaseMiddleware
{
    abstract public function execute();
}
