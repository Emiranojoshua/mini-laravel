<?php

namespace Core\Exception\Foundation;

interface ExceptionInterface
{
    public  function getErrorCode(): int;
    public  function getErrorName(): string;
    public  function getErrorMessage(): string;
}
