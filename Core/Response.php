<?php

namespace Core;

enum Response: int
{
    case NOT_FOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;
    case OK = 200;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case METHOD_NOT_ALLOWED = 405;
    case REDIRECT = 202;
    case FORBIDDEN = 403;

    public function getName()
    {
        return match ($this) {
            self::METHOD_NOT_ALLOWED => $this->name,
            self::NOT_FOUND => $this->name,
            self::INTERNAL_SERVER_ERROR => $this->name,
            self::OK => $this->name,
            self::UNAUTHORIZED => $this->name,
            self::REDIRECT => $this->name,
            self::FORBIDDEN => $this->name,
        };
    }
    public function getValue()
    {
        return match ($this) {
            self::METHOD_NOT_ALLOWED => $this->value,
            self::NOT_FOUND => $this->value,
            self::INTERNAL_SERVER_ERROR => $this->value,
            self::OK => $this->value,
            self::UNAUTHORIZED => $this->value,
            self::REDIRECT => $this->value,
            self::FORBIDDEN => $this->value,
        };
    }
}
