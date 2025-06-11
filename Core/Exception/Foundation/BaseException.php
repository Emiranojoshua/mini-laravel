<?php

namespace Core\Exception\Foundation;

use Core\Exception\AuthException\AuthException;
use Core\Exception\RouterException\NotFoundException;
use Core\Response;
use Exception;
use Throwable;


abstract class BaseException extends Exception implements ExceptionInterface
{
    private string $errorName;
    private int $errorCode;
    private string $errorMessage;

    public function __construct(?Response $errorCode = null, ?string $message = null, int $code = 0, ?Throwable $previous = null)
    {

        $errorResponse = $this->setError();
        $this->errorName = $errorCode?->getName() ?? $errorResponse->getName();
        $this->errorCode =  $errorCode?->getValue() ?? $errorResponse->getValue();
        $this->errorMessage = $message ?? $this->setErrorMessage();

        // Call parent constructor with the message
        parent::__construct($this->errorMessage, $code, $previous);
    }


    abstract protected function setError(): Response;

    abstract public function setErrorMessage(): string;


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

    public static function throwException(
        string $errorMessage,
        Response $errorCode,
        int $code = 0,
        ?Throwable $previous = null
    ): static {
        return new static(
            $errorCode,
            $errorMessage,
            $code,
            $previous
        );
    }
}
