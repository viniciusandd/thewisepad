<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\UserEntity;
use Src\Domain\UseCases\Errors\ExistingUserError;
use Src\Domain\UseCases\SignUpUseCase;
use Src\Presentation\Controllers\Contracts\HttpRequest;
use Src\Presentation\Controllers\SignUpOperation;

class SignUpOperationTest extends TestCase
{
    private SignUpOperation $sut;
    private $mockSignUpUseCase;
    private $faker;
    private $email;
    private $password;

    protected function setUp(): void
    {
        $this->mockSignUpUseCase = $this->createMock(SignUpUseCase::class);

        $this->sut = new SignUpOperation($this->mockSignUpUseCase);

        $this->faker = Faker\Factory::create();

        $this->email = $this->faker->email;

        $this->password = $this->faker->password;
    }

    public function testForbiddenResponse()
    {
        $this->mockSignUpUseCase->method('exec')
            ->will($this->throwException(new ExistingUserError()));

        $httpRequest = new HttpRequest([
            "email" => $this->email,
            "password" => $this->password
        ]);
        
        $httpResponse = $this->sut->specificOp($httpRequest);

        $this->assertEquals(403, $httpResponse->getStatusCode());
    }

    public function testBadRequestResponse()
    {
        $this->mockSignUpUseCase->method('exec')
            ->will($this->throwException(new Exception()));

        $httpRequest = new HttpRequest([
            "email" => $this->email,
            "password" => $this->password
        ]);
        
        $httpResponse = $this->sut->specificOp($httpRequest);

        $this->assertEquals(400, $httpResponse->getStatusCode());
    }

    public function testCreatedResponse()
    {
        $this->mockSignUpUseCase->method('exec')
            ->willReturn(UserEntity::create($this->email, $this->password));

        $httpRequest = new HttpRequest([
            "email" => $this->email,
            "password" => $this->password
        ]);
        
        $httpResponse = $this->sut->specificOp($httpRequest);

        $this->assertEquals(201, $httpResponse->getStatusCode());
    }
}