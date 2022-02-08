<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Models\UserModel;
use Src\External\Repositories\MySql\MySqlUserRepository;

class MySqlUserRepositoryTest extends TestCase
{
    private $sut;

    public static function setUpBeforeClass(): void
    {
        system('vendor/bin/doctrine orm:schema-tool:drop --force && vendor/bin/doctrine orm:schema-tool:create');
        system('vendor/bin/doctrine dbal:run-sql "$(cat tests/External/Repositories/MySQL/FakeData.sql)"');
    }

    protected function setUp(): void
    {
        $this->sut = new MySqlUserRepository($entityManager);
    }

    public function testFindUserByEmail()
    {
        $this->markTestSkipped();

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
}