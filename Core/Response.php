<?php

namespace Core;

// class Response
// {
//     public const int NOT_FOUND = 404;
//     public const  int METHOD_NOT_ALLOWED = 403;
//    public  const int  UNAUTHORIZED = 401;
//    public  const int  SERVER_ERROR = 500;
//     public const int  OK  = 200;
//     public const int  BAD_REQUEST = 400;
// }

enum Response: int
{
    case NOT_FOUND = 404;
    case SERVER_ERROR = 500;
    case OK = 200;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case METHOD_NOT_ALLOWED = 403;
}
