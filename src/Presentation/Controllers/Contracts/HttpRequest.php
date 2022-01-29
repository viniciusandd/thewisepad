<?php

namespace Src\Presentation\Controllers\Contracts;

class HttpRequest
{
    private $body;

    public function __construct($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}