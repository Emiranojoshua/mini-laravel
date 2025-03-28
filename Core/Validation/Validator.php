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
            foreach ($ruleArray as $rule) {
                if ($rule === 'required' && empty($this->data[$field])) {
                    $this->addError($field, "$field is required");
                }
            }
        }
        // dd($this->rules);
    }
}
