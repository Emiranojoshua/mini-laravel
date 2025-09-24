<?php

namespace Core\Components;

trait ResponseComponent
{
    public array $response = ["status" => "", "errors" => "", "data" => []];
}
