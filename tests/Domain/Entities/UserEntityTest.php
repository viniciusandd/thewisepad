<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\UserEntity;
use Src\Domain\Entities\Errors\InvalidUserEmailError;
use Src\Domain\Entities\Errors\InvalidUserPasswordError;

class UserEntityTest extends TestCase
{
    private $email;
    private $password;

    protected function setUp() : void
    {
        $faker = Faker\Factory::create();
        
        $this->email = $faker->email;
        $this->password = $faker->password;
    }

    public function testCreateValidUser()
    {
        $user = UserEntity::create($this->email, $this->password);

        $this->assertEquals($this->email, $user->getEmail());
        $this->assertEquals($this->password, $user->getPassword());
    }

    public function testCreateUserWithoutEmail()
    {
        $this->expectException(InvalidUserEmailError::class);
        
        UserEntity::create(null, $this->password);
    }

    public function testCreateUserWithoutPassword()
    {
        $this->expectException(InvalidUserPasswordError::class);
        
        UserEntity::create($this->email, null);
    }
}