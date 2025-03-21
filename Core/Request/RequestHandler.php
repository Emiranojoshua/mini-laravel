<?php

namespace Core;

class RequestHandler
{

    public array $data;


    public function __construct()
    {

        $this->data = $_POST;
    }

    public function all()
    {
        return $this->data = $_POST;
        // return $this;
    }



    public function except(array $key = [])
    {
        $data = array_diff_key($this->data, array_flip($key));

        return $data;
    }
}
