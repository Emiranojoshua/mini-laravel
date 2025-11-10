<?php

namespace Core;

enum Middleware: string
{
    case AUTH = "AUTH";
    case GUEST = "GUEST";

    // case DEFAULT = "AUTH";
}
