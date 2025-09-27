<?php

namespace Core\Validation;

use Core\Response\Responsable;
use Core\Response\ResponseComponent;
use Core\Response\ResultStatus;

/**
 * @method array all()
 */

abstract class Validator implements Responsable
{
    use BaseValidator;
    use ResponseComponent;

    public function validate(array $rules): ?array
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
            return $this->sendResponse(ResultStatus::FAILED, $this->getErrors(), $data);
        };
        return $this->sendResponse(status: ResultStatus::SUCCESS, responseData: $data);
    }
}
