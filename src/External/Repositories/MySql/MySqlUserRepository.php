<?php

namespace Src\External\Repositories\MySql;

use Src\Domain\Models\UserModel;
use Src\Domain\Repositories\UserRepository;

class MySqlUserRepository implements UserRepository
{
    private $helper;

    public function __construct($helper)
    {
        $this->helper = $helper;
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
        $sql = "insert into users (email, password) values (?, ?)";
        $params = [$userModel->getEmail(), $userModel->getPassword()];
        $this->helper->insert($sql, $params);
    }
}