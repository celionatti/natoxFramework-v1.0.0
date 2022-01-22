<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\exception;

/**
 * 
 * @author
 * @package natoxCore\exception
 */

class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}