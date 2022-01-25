<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Models\UserModel;
use Src\Domain\UseCases\SignUpUseCase;
use Src\Domain\UseCases\Errors\ExistingUserError;
use Src\Domain\Repositories\UserRepository;

class SignUpUseCaseTest extends TestCase
{
    private $sut;
    private $mockUserRepository;
    private $email;
    private $password;

    protected function setUp(): void
    {
        $this->mockUserRepository = $this->createMock(UserRepository::class);

        $this->sut = new SignUpUseCase($this->mockUserRepository);
        
        $faker = Faker\Factory::create();

        $this->email = $faker->email;
        $this->password = $faker->password;
    }

    public function testUserAlreadyExist()
    {
        $this->mockUserRepository->method('findByEmail')
             ->willReturn(new UserModel($this->email, $this->password));

        $this->expectException(ExistingUserError::class);

        $userEntity = $this->sut->exec($this->email, $this->password);
    }

    public function testSuccessfullySignUp()
    {
        $this->mockUserRepository->method('findByEmail')
             ->willReturn(null);
        
        $userEntity = $this->sut->exec($this->email, $this->password);

        $this->assertEquals($this->email, $userEntity->getEmail());
        $this->assertEquals($this->password, $userEntity->getPassword());
    }
}