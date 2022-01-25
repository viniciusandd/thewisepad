<?php

namespace Src\Domain\UseCases\Errors;

use Exception;

class ExistingUserError extends Exception
{
    private $errorMessage = "There is already a user with that email address";

    public function __construct()
    {
        parent::__construct($this->errorMessage);
    }
}