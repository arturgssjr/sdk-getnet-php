<?php

namespace GetnetTests\Api\Requests;

use Getnet\Api\Authentication;
use Getnet\Api\Environment;
use Getnet\Api\Exceptions\GetnetException;
use Getnet\Api\Requests\RequestAbstract;
use Getnet\Api\Seller;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

class RequestAbstractTest extends TestCase
{

    private $data;
    private $seller;
    private $environment;
    private $authentication;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->environment = new Environment();
        $this->seller = new Seller($this->data['seller']['client_id'], $this->data['seller']['secret_id'], $this->data['seller']['seller_id']);
        $this->authentication = new Authentication($this->seller);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->environment);
        unset($this->seller);
        unset($this->authentication);
    }

    public function testSendRequestOk()
    {
        $testedClass = $this->getMockForAbstractClass(RequestAbstract::class, [
            $this->authentication,
            $this->environment,
        ]);
        
        $reflector = new ReflectionObject($testedClass);
        
        $sendRequest = $reflector->getMethod('sendRequest');
        $sendRequest->setAccessible(true);

        $return = $sendRequest->invokeArgs(
            $testedClass, [
                RequestAbstract::HTTP_GET,
                'http://viacep.com.br/ws/74915380/json/',
            ]
        );

        $this->assertIsArray($return);
        $this->assertEquals(200, $return['statusCode']);
    }

    public function testSendRequestCurlError()
    {
        $this->expectException(GetnetException::class);
        $this->expectExceptionCode(RequestAbstract::CURL_ERROR_CODE);
        $this->expectExceptionMessage('Curl error: ');

        $testedClass = $this->getMockForAbstractClass(RequestAbstract::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $sendRequest = $reflector->getMethod('sendRequest');
        $sendRequest->setAccessible(true);

        $sendRequest->invokeArgs(
            $testedClass, [
                RequestAbstract::HTTP_GET,
                '',
            ]
        );
    }

}
