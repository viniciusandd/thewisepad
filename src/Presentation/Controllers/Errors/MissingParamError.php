<?php

namespace Src\Presentation\Controllers\Errors;

use Exception;

class MissingParamError extends Exception
{
    public function __construct(string $missingParameters)
    {
        parent::__construct("Missing parameters: $missingParameters");
    }
}