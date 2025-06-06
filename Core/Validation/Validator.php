<?php

namespace Core\Validation;


class Validator
{
    use BaseValidator;

    public function __construct(
        protected array $rules,
        protected array $data
    ) {
        $this->validate();
    }

    public function validate()
    {
        foreach ($this->rules as $field => $ruleArray) {
            $value = $this->data[$field] ?? null;
            foreach ($ruleArray as $rule) {
                [$rulename, $rulevalue] = $this->parseRule($rule);

                if (!is_string($rule)) {
                    continue; // skip anything that's not a string
                }

                [$ruleName, $ruleValue] = $this->parseRule($rule);

                if ($ruleName === 'nullable' && ($value === null || $value === '')) {
                    break; // skip other rules if nullable and empty
                }

                if (!$this->applyRule($ruleName, $value, $ruleValue)) {
                    $this->addError($field, $this->errorMessage($field, $ruleName, $ruleValue));
                }
            }
        }
    }
}
