<?php

namespace Core\Request;

use Core\Validation\Validator;
use Exception;

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


    public function validate(array $rules): mixed
    {
        $validator =  new Validator($rules, $this->all());

        if (!$validator->passes()) {
            session_flash($validator->getErrors());
            session_old($this->all());
            //coming back for this return value
            //redirection 
            return false;
        };

        //return valdation value
        return true;
    }

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

    public function get(string $value): mixed
    {

        return $this->all()[$value] ?? throw new Exception('invalid parameter');
    }
}
