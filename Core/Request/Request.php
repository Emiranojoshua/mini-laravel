<?php

namespace Core\Request;

use Core\Exception\ServerException\RequestErrorException;
use Core\Response;
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


    public function validate(array $rules): array
    {
        $validator =  new Validator($rules, $this->all());

        if (!$validator->passes()) {
            session_flash($validator->getErrors());
            session_old($this->all());

            redirect()->back()->setStatus(Response::REDIRECT)->send();
            exit;
            // $request = Request::getRequest();

            // back();
        };

        return $this->all();
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

    public static function getRequest(bool $requestData = false): array
    {
        $requestData = $_SERVER;
        return $requestData;
    }

    public static function getRequestUri(): string
    {
        return parse_url(static::getRequest()['REQUEST_URI'])['path'] ?? '/';
    }
    public static function getRequestMethod(): string
    {
        return parse_url(static::getRequest()['REQUEST_METHOD'])['path']
            ??
            throw RequestErrorException::throwException(
                "The requested method does not exist",
                Response::BAD_REQUEST
            );
    }
}
