<?php

namespace Src\Presentation\Controllers\Contracts;

class HttpResponse
{
    private $statusCode;
    private $body;

    public function __construct($statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getBody()
    {
        return $this->body;
    }
}