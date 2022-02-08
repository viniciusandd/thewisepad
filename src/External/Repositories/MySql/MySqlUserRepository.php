<?php

namespace Src\External\Repositories\MySql;

use Doctrine\ORM\EntityManager;
use Src\Database\Models\User;
use Src\Domain\Models\UserModel;
use Src\Domain\Repositories\UserRepository;

class MySqlUserRepository implements UserRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByEmail($email): UserModel
    {
        $sql = "select email, password from users where email = ?";
        $params = [$email];
        $result = $this->helper->get($sql, $params);
        return new UserModel($result["email"], $result["password"]);
    }

    public function add(UserModel $userModel)
    {
        $user = new User();
        $user->setEmail($userModel->getEmail());
        $user->setPassword($userModel->getPassword());

        var_dump($user);
        var_dump($this->entityManager);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}