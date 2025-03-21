<?php 

namespace Core\Exception\DatabaseException;

use Core\Exception\ThrowExceptionTrait;
use Exception;

class DatabaseException extends Exception{
    use ThrowExceptionTrait;
}