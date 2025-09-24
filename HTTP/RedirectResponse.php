<?php

// namespace HTTP;

// use Core\Request\Request;
// use Core\Response;

// class RedirectResponse
// {
//     protected string $url;
//     protected Response $statusCode;
//     protected array $flashData = [];

//     //testing instance in redirect response
//     private static ?RedirectResponse $instance = null;



//     private function __construct(string $url, Response $statusCode = Response::REDIRECT)
//     {
//         $this->url = $url;
//         $this->statusCode = $statusCode;
//     }

//     public static function make(string $url, Response $statusCode = Response::REDIRECT): static
//     {
//         if(self::$instance == null){
//             self::$instance = new self($url, $statusCode);
//         }
//         return self::$instance;
//         // return new static($url, $statusCode);
//     }

//     public function with(array $data): static
//     {
//         session_flash($data);
//         return $this;
//     }

//     public function back(): static
//     {
//         // $referer = $_SERVER['HTTP_REFERER'] ?? '/';
//         $request = Request::getRequestUri();
//         $this->url = $request;
//         return $this;
//     }

//     public function setStatus(Response $statusCode): static
//     {
//         $this->statusCode = $statusCode;
//         return $this;
//     }

//     public function to(string $url): void
//     {
//         // request_status_code($this->statusCode);
//         view(path: $url, response_code:$this->statusCode);
//         return;
//         //
//         // header("Location: $url");
//         // exit;
//     }

//     public function send(): void
//     {
//         $this->to($this->url);
//     }
// }





namespace HTTP;

use Core\Request\Request;
use Core\Response;

class RedirectResponse
{
    protected string $url;
    protected Response $statusCode;
    protected array $flashData = [];

    public function __construct(string $url, Response $statusCode = Response::OK)
    {
        $this->url = $url;
        $this->statusCode = $statusCode;
    }

    public static function make(string $url, Response $statusCode = Response::OK): static
    {
        return new static($url, $statusCode);
    }

    // Flash session data
    public function with(array $data): static
    {
        session_flash($data);
        return $this;
    }

    // Go back to referrer
    public function back()
    {
        $this->url = $_SERVER['HTTP_REFERER'] ?? '/';
        return $this->send();
    }

    // Refresh current page
    public function refresh()
    {
        $this->url = Request::getRequestUri();
        return $this->send();
    }

    public function to()
    {
        return $this->send();
    }

    // Final send
    public function send(): void
    {
        // dd($this->url);
        header("Location: {$this->url}", true, $this->statusCode->getValue());
        exit();
    }
}
