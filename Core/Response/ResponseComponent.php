<?php

namespace Core\Response;

use Core\Response\ResponseStatus;
use Core\Exception\ArgumentException\InvalidArgumentException;
use Core\Response;

trait ResponseComponent
{
    private array $response = [
        "status" => "",
        "errors" => "",
        "formData" => [],
        "responseData" => []
    ];

    public function sendResponse(ResultStatus $status, array $errors = [], array $formData = [], $responseData = null)
    {
        $this->response['status'] = $status;
        $this->response['errors'] = $errors;
        $this->response['formData'] = $formData;
        $this->response['responseData'] = $responseData;
        if ($responseData == null || $responseData === null) {
            return null;
        }
        return $responseData;
    }

    public function getResponse(string $value = "")
    {
        if ($value == "" || strlen($value) <= 0) {
            return $this->response;
        }
        if (array_key_exists($value, $this->response)) {
            return $this->response[$value];
        }
        return throw InvalidArgumentException::throwException(
            "Invalid {$value} argument passed",
            Response::METHOD_NOT_ALLOWED
        );
    }
    
}
