<?php

namespace Core\Exception\Foundation;

use Core\Request\Request as CoreRequest;
use Core\Response;

final class ExceptionDetails
{
    private BaseException $exception;

    private string $originFile;
    private int $originLine;

    private array $trace;
    private string $traceString;

    public function __construct(BaseException $e)
    {
        $this->exception = $e;

        $this->trace = $e->getTrace();
        $this->traceString = $e->getTraceAsString();

        // determine the true origin file and line
        $origin = $this->detectOrigin($this->trace);
        $this->originFile = $origin['file'];
        $this->originLine = $origin['line'];
    }

    private function detectOrigin(array $trace): array
    {
        foreach ($trace as $frame) {
            if (!isset($frame['file'])) continue;

            $file = $frame['file'];

            // Skip internal framework files
            if (str_contains($file, 'Core/')) continue;

            // Skip global helper functions
            if (str_contains($file, 'functions.php')) continue;

            // First user-land file = origin
            return [
                'file' => $file,
                'line' => $frame['line'] ?? 0,
            ];
        }

        return ['file' => 'unknown', 'line' => 0];
    }

    // ====== Getters ======
    public function getErrorCode(): int
    {
        return $this->exception->getErrorCode() ?: Response::INTERNAL_SERVER_ERROR->getValue();
    }

    public function getErrorName(): string
    {
        return $this->exception->getErrorName() ?: 'Internal Server Error';
    }

    public function getErrorMessage(): string
    {
        return $this->exception->getErrorMessage() ?: 'An error occurred/internal server error';
    }

    public function getOriginFile(): string
    {
        return $this->originFile;
    }

    public function getOriginLine(): int
    {
        return $this->originLine;
    }

    public function getTrace(): array
    {
        return $this->trace;
    }

    public function getTraceString(): string
    {
        return $this->traceString;
    }

    public function getRequestData(): array
    {
        return CoreRequest::getRequest();
    }
}
