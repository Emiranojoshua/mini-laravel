<?php

namespace Core;
enum Response: int
{
    case NOT_FOUND = 404;
    case SERVER_ERROR = 500;
    case OK = 200;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case METHOD_NOT_ALLOWED = 403;
}
