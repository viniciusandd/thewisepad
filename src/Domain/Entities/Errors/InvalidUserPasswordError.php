<?php

namespace Src\Domain\Entities\Errors;

use Exception;

class InvalidUserPasswordError extends Exception
{
    private $errorMessage = "User password is invalid";

    public function __construct()
    {
        parent::__construct($this->errorMessage);
    }
}