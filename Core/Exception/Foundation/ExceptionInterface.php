<?php

namespace Core\Exception\Foundation;

use Core\Response;

interface ExceptionInterface
{
    public  function getErrorCode(): int;
    public  function getErrorName(): string;
    public  function getErrorMessage(): string;
}
