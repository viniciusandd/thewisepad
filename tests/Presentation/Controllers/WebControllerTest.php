<?php

use PHPUnit\Framework\TestCase;
use Src\Presentation\Controllers\Contracts\ControllerOperation;
use Src\Presentation\Controllers\Contracts\HttpRequest;
use Src\Presentation\Controllers\Contracts\HttpResponse;
use Src\Presentation\Controllers\WebController;

class WebControllerTest extends TestCase
{
    private WebController $sut;
    private $mockControllerOperation;

    protected function setUp(): void
    {
        $this->mockControllerOperation = $this->createMock(ControllerOperation::class);

        $this->sut = new WebController($this->mockControllerOperation);
    }

    public function testRequestWithoutRequiredParam()
    {
        $this->mockControllerOperation->method('getRequiredParams')
            ->willReturn(['any_key_1', 'any_key_2', 'any_key_3']);

        $httpRequest = new HttpRequest([
            'any_key_1' => 'any_value_1',
            'any_key_2' => 'any_value_2',
        ]);

        $missingParams = $this->sut->getMissingParams($httpRequest);

        $this->assertTrue($missingParams == 'any_key_3');
    }

    public function testRequestWithoutRequiredParams()
    {
        $this->mockControllerOperation->method('getRequiredParams')
            ->willReturn(['any_key_1', 'any_key_2', 'any_key_3']);

        $httpRequest = new HttpRequest(['any_key_1' => 'any_value_1']);

        $missingParams = $this->sut->getMissingParams($httpRequest);

        $this->assertTrue($missingParams == 'any_key_2,any_key_3');
    }

    public function testBadRequestResponse()
    {
        $this->mockControllerOperation->method('getRequiredParams')
            ->willReturn(['any_key_1', 'any_key_2', 'any_key_3']);

        $httpRequest = new HttpRequest(['any_key_1' => 'any_value_1']);

        $httpResponse = $this->sut->handle($httpRequest);

        $this->assertEquals(400, $httpResponse->getStatusCode());
    }

    public function testServerErrorResponse()
    {
        $this->mockControllerOperation->method('specificOp')
            ->will($this->throwException(new Exception()));

        $httpRequest = new HttpRequest(['any_key_1' => 'any_value_1']);

        $httpResponse = $this->sut->handle($httpRequest);

        $this->assertEquals(500, $httpResponse->getStatusCode());
    }

    public function testSuccessResponse()
    {
        $this->mockControllerOperation->method('specificOp')
            ->willReturn(new HttpResponse(200, []));

        $httpRequest = new HttpRequest(['any_key_1' => 'any_value_1']);

        $httpResponse = $this->sut->handle($httpRequest);

        $this->assertEquals(200, $httpResponse->getStatusCode());
    }
}