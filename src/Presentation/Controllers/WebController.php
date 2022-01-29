<?php

namespace Src\Presentation\Controllers;

use Src\Presentation\Controllers\Contracts\ControllerOperation;
use Src\Presentation\Controllers\Contracts\HttpRequest;
use Src\Presentation\Controllers\Contracts\HttpResponse;
use Src\Presentation\Controllers\Errors\MissingParamError;
use Src\Presentation\Controllers\Utils\HttpHelper;

class WebController
{
    private ControllerOperation $controllerOperation;

    public function __construct(ControllerOperation $controllerOperation)
    {
        $this->controllerOperation = $controllerOperation;
    }

    public function handle(HttpRequest $httpRequest) : HttpResponse
    {
        try {
            $missingParams = $this->getMissingParams($httpRequest);
            if ($missingParams) {
                return HttpHelper::badRequest(new MissingParamError($missingParams));
            }
            return $this->controllerOperation->specificOp($httpRequest);
        } catch (\Throwable $th) {
            return HttpHelper::serverError($th);
        }
    }

    public function getMissingParams(HttpRequest $httpRequest) : string
    {
        $missingParams = [];
        foreach ($this->controllerOperation->getRequiredParams() as $_ => $requiredParam) {
            if (!array_key_exists($requiredParam, $httpRequest->getBody())) {
                array_push($missingParams, $requiredParam);
            }
        }
        return implode(',', $missingParams);
    }
}