<?php

namespace Src\Presentation\Controllers;

use Throwable;
use Src\Domain\UseCases\Errors\ExistingUserError;
use Src\Presentation\Controllers\Contracts\ControllerOperation;
use Src\Presentation\Controllers\Contracts\HttpRequest;
use Src\Presentation\Controllers\Contracts\HttpResponse;
use Src\Presentation\Controllers\Utils\HttpHelper;

class SignUpOperation implements ControllerOperation
{
    private $requiredParams = ['email', 'password'];
    private $useCase;

    public function __construct($useCase)
    {
        $this->useCase = $useCase;
    }
    
    public function getRequiredParams(): array
    {
        return $this->requiredParams;
    }

    public function specificOp(HttpRequest $httpRequest): HttpResponse
    {
        try {
            $userEntity = $this->useCase->exec(
                $httpRequest->getBody()['email'],
                $httpRequest->getBody()['password']);
            return HttpHelper::created([
                'email' => $userEntity->getEmail(),
                'password' => $userEntity->getPassword()
            ]);
        } catch (ExistingUserError $eue) {
            return HttpHelper::forbidden($eue);
        } catch (Throwable $th) {
            return HttpHelper::badRequest($th);
        }
    }
}