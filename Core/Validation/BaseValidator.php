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

    protected function parseRule($rule): array
    {
        if (str_contains($rule, ':')) {
            return explode(':', $rule, 2);
        }
        return [$rule, null];
    }

    protected function applyRule($rule, $value, $param): bool
    {
        return match ($rule) {
            'required' => $value !== null && $value !== '',
            'email' => filter_var($value, FILTER_VALIDATE_EMAIL) !== false,
            'min' => is_string($value) && strlen($value) >= (int) $param,
            'max' => is_string($value) && strlen($value) <= (int) $param,
            'string' => is_string($value),
            'numeric' => is_numeric($value),
            'nullable' => true, 
            default => true, 
        };
    }

    protected function errorMessage(string $field, string $rule, $param): string
    {
        return match ($rule) {
            'required' => "$field is required.",
            'email' => "$field must be a valid email address.",
            'min' => "$field must be at least $param characters.",
            'max' => "$field must be no more than $param characters.",
            'string' => "$field must be a string.",
            'numeric' => "$field must be a number.",
            default => "$field is invalid.",
        };
    }

}