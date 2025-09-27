<?php

namespace Core\Response;

interface Responsable
{
    public function sendResponse(
        ResultStatus $status,
        array $errors = [],
        array $formData = [],
        $responseData = null
    );

    public function getResponse(string $value = "");
}
