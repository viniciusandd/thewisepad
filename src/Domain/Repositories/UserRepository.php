<?php

namespace Src\Domain\Repositories;

use Src\Domain\Models\UserModel;

interface UserRepository
{
    public function findByEmail($email);
    public function add(UserModel $userModel);
}