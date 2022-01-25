<?php

namespace Src\Domain\Entities;

use Src\Domain\Entities\Errors\InvalidUserEmailError;
use Src\Domain\Entities\Errors\InvalidUserPasswordError;

class UserEntity
{
    private $email;
    private $password;

    private function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function create($email, $password) : UserEntity
    {
        if (empty($email))
        {
            throw new InvalidUserEmailError();
        }

        if (empty($password))
        {
            throw new InvalidUserPasswordError();
        }

        return new UserEntity($email, $password);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
}