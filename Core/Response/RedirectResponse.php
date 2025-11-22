<?php

namespace Core\Response;

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
        header("Location: {$this->url}", true, $this->statusCode->getValue());
        exit();
    }
}
