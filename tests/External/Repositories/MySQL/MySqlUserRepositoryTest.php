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
        system('vendor/bin/doctrine orm:schema-tool:drop --force && vendor/bin/doctrine orm:schema-tool:create');
        system('vendor/bin/doctrine dbal:run-sql "$(cat tests/External/Repositories/MySQL/FakeData.sql)"');

        $host = getenv('DB_HOST');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        $dbname = getenv('DB_NAME');

        self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
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