<?php

declare(strict_types=1);

/**User: Celio Natti ** */

namespace natoxCore\form;

use natoxCore\helpers\GenerateToken;
use natoxCore\Model;

/**
 * class Form
 * 
 * @author Celio Natti <Celionatti@gmail.com>
 * @package natoxCore\core\form
 */

class Form
{    
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }

    public function csrfInput()
    {
        return '<input type="hidden" name="csrf_token" id="csrf_token" value="'.GenerateToken::CreateToken().'" />';
    }

}
