<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\exception;

/**
 * 
 * @author
 * @package natoxCore\exception
 */

class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}