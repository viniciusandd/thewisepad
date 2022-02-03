<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Models\UserModel;
use Src\External\Repositories\MySql\Helper;
use Src\External\Repositories\MySql\MySqlUserRepository;

class MySqlUserRepositoryTest extends TestCase
{
    private static $pdo;
    private $sut;

    public static function setUpBeforeClass(): void
    {
        $dsn = getenv('DB_DSN');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        self::$pdo = new PDO($dsn, $user, $password);
    }

    protected function setUp(): void
    {
        $helper = new Helper(self::$pdo);
        $this->sut = new MySqlUserRepository($helper);
    }

    public function testFindUserByEmail()
    {
        $email = "vinicius@gmail.com";
        
        $userModel = $this->sut->findByEmail($email);

        $this->assertEquals($email, $userModel->getEmail());
    }

    public function testAddUser()
    {
        $faker = Faker\Factory::create();
        $email = $faker->email;
        $password = $faker->password;

        $this->sut->add(new UserModel($email, $password));

        $userModel = $this->sut->findByEmail($email);
        $this->assertEquals($email, $userModel->getEmail());
    }

    public static function tearDownAfterClass(): void
    {
        self::$pdo = null;
    }
}