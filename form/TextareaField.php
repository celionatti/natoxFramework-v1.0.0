<?php

declare(strict_types=1);

/**User: Celio Natti ** */

namespace natoxCore\form;

/**
 * Class TextareaField
 * 
 * @author Celio Natti <Celionatti@gmail.com>
 * @package natoxCore\form
 */

class TextareaField extends BaseField
{
    public function renderInput(): string
    {
        return sprintf(
            '<textarea name="%s" class="form-control%s" id="%s">%s</textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
        );
    }
}
