<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\validation;

class FormValidation
{
    private $data;
    private $errors;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules): ?array
    {
        foreach ($rules as $name => $rulesArray) {
            if (array_key_exists($name, $this->data)) {
                foreach ($rulesArray as $rule) {
                    switch ($rule) {
                        case 'required':
                            $this->required($name, $this->data[$name]);
                            break;
                        case substr($rule, 0, 3) === 'min':
                            $this->min($name, $this->data[$name], $rule);
                            break;
                        case 'email':
                            $this->validEmail($name, $this->data[$name]);
                        default:
                            # code...
                            break;
                    }
                }
            }
        }

        return $this->getErrors();
    }

    private function required(string $name, string $value)
    {
        $value = trim($value);

        if (!isset($value) || is_null($value) || empty($value)) {
            $this->errors[$name][] = "{$name} is required!.";
        }
    }

    private function validEmail(string $name, string $value)
    {
        $value = filter_var($value, FILTER_SANITIZE_EMAIL);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name][] = "{$value} is not a valid E-Mail address!.";
        }
    }

    private function min(string $name, string $value, string $rule)
    {
        preg_match_all('/(\d+)/', $rule, $matches);
        $limit = (int) $matches[0][0];

        if (strlen($value) < $limit) {
            $this->errors[$name][] = "{$name} minimum length of {$limit} characters";
        }
    }

    private function getErrors(): ?array
    {
        return $this->errors;
    }

}
