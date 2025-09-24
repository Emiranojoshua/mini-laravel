<?php

namespace Core\Validation;

use Core\Components\ResponseComponent;

/**
 * @method array all()
 */

abstract class Validator
{
    use BaseValidator;
    use ResponseComponent;

    // public function __construct(
    //     protected array $rules,
    //     protected array $data
    // ) {
    //     $this->validator();
    // }



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

            $this->response['status'] = "failed";
            $this->response['errors'] = $this->getErrors();
            $this->response['data'] = $data;

            return null;

            // session_flash($this->getErrors());
            // session_old($data);
            // view('/login');
            // exit();
            // header("Location: /login");
            // exit();
            // redirect(statusCode: Response::REDIRECT)->back();
            // exit;
            // $request = Request::getRequest();

            // back();
        };

        $this->response['status'] = "failed";
        return $data;

        // return $data;
    }
}
