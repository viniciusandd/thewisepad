<?php

namespace Src\External\Repositories\MySql;

use PDO;

class Helper
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function get(string $sql, array $params) : array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($sql, $params)
    {
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
}