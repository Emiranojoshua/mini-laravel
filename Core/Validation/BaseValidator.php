<?php 

namespace Core\Validation;

trait BaseValidator{

    protected array $errors = [];

    public function getErrors(): mixed
    {
        return $this->errors;
    }


    public function addError(string $field,  string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

}