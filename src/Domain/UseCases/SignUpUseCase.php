<?php

namespace Src\Domain\UseCases;

use Src\Domain\Entities\UserEntity;
use Src\Domain\Repositories\UserRepository;
use Src\Domain\UseCases\Errors\ExistingUserError;

class SignUpUseCase
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function exec($email, $password) : UserEntity
    {
        if ($this->userRepository->findByEmail($email))
        {
            throw new ExistingUserError();
        }

        return UserEntity::create($email, $password);
    }
}