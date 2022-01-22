<?php

declare(strict_types=1);

/**User: Celio Natti** */

namespace natoxCore\form;

use natoxCore\Model;

/**
 * Class BaseField
 * 
 * @author Celio Natti <Celionatti@gmail.com>
 * @package natoxCore\form
 */

abstract class BaseField
{
    public Model $model;
    public string $attribute;

    /**
     * Class constructor
     * @param \natoxCore\Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function renderInput(): string;

    public function __toString()
    {
        return sprintf(
            '
                <div class="mb-3">
                    <label for="%s" class="form-label">%s</label>
                    %s
                    <div id="" class="form-text invalid-feedback">
                        %s
                    </div>
                </div>
            ',
            $this->attribute,
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}
