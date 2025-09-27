<?php 

namespace Core\Response;

enum ResultStatus: string{
    case FAILED = "false";
    case SUCCESS = "true";
}