<?php

namespace Src\Presentation\Controllers\Contracts;

/**
 * @property requiredParams
 */
interface ControllerOperation
{
    public function getRequiredParams() : array;
    public function specificOp(HttpRequest $httpRequest) : HttpResponse;
}