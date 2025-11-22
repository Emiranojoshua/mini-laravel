<?php

namespace Core\Exception\Foundation;

use Core\Response;
use Exception;
use Throwable;


abstract class BaseException extends Exception implements ExceptionInterface
{
    private string $errorName;
    private int $errorCode;
    private string $errorMessage;
    private Response $error;
    

    final private function __construct(
        ?Response $errorCode = null,
        ?string $message = null,
        int $code = 0,
        ?Throwable $previous = null
    ) {

        $errorResponse = $this->setError();
        $this->error = $errorResponse;
        $this->errorName = $errorCode?->getName() ?? $errorResponse->getName();
        $this->errorCode =  $errorCode?->getValue() ?? $errorResponse->getValue();
        $this->errorMessage = $message ?? $this->setErrorMessage();

        // Call parent constructor with the message
        parent::__construct($this->errorMessage, $code, $previous);
        // return;
    }


    abstract protected function setError(): Response;

    abstract protected function setErrorMessage(): string;


    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getErrorName(): string
    {
        return $this->errorName;
    }
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getError(): Response{
        return $this->error;
    }

    /**
     * @param null|string $errorMessage the exception message to be thrown, defaults to called class $errorMessage
     * @param null|Response $errorCode the exception Response type, defaults to called class $errorCode
     * @param int $code Exception code 
     * @return static returns an exception 
     */

    public static function throwException(
        string $errorMessage,
        Response $errorCode ,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        throw new static(
            $errorCode,
            $errorMessage,
            $code,
            $previous
        );
    }
}
