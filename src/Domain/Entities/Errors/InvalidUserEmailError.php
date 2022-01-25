<?php

namespace Src\Domain\Entities\Errors;

use Exception;

class InvalidUserEmailError extends Exception
{
    private $errorMessage = "User email is invalid";

    public function __construct()
    {
        parent::__construct($this->errorMessage);
    }
}