<?php

// namespace   Core\Request;

// use Core\RequestHandler;

// class Request
// {

//     public static $instance;

//     public static function __callStatic($method, $args)
//     {
//         if (self::$instance == null) {
//             self::$instance = new RequestHandler();
//         }

//         return self::$instance->$method(...$args);
//     }
// }


namespace Core\Request;

class Request
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

    public function validate(array $args = []) {}

    public function only(array $keys)
    {
        $filtered = [];
        // dd($this->data)



        foreach ($keys as $key) {
            if (array_key_exists($key, $this->data)) {
                $filtered[$key] = $this->data[$key];
            }
        }

        return $filtered;
    }
}
