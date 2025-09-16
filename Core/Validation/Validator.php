<?php

namespace Core\Validation;

use Core\Request\Request;
use Core\Response;

/**
 * @method array all()
 */

abstract class Validator
{
    use BaseValidator;

    // public function __construct(
    //     protected array $rules,
    //     protected array $data
    // ) {
    //     $this->validator();
    // }

    public function validate(array $rules): array
    {
        $data  = $this->all();

        foreach ($rules as $field => $ruleArray) {
            $value = $data[$field] ?? null;
            foreach ($ruleArray as $rule) {
                // dc($rule);
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

        if (!$this->passes()) {
            session_flash($this->getErrors());
            session_old($data);

            redirect()->back()->setStatus(Response::REDIRECT)->send();
            exit;
            // $request = Request::getRequest();

            // back();
        };

        return $data;
    }

}
