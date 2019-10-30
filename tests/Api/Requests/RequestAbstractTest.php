<?php

namespace GetnetTests\Api\Requests;

use ReflectionClass;
use ReflectionObject;
use Getnet\Api\Seller;
use Getnet\Api\Environment;
use Getnet\Api\Authentication;
use PHPUnit\Framework\TestCase;
use Getnet\Api\Requests\RequestAbstract;
use Getnet\Api\Exceptions\GetnetException;

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

        $setUrl = $reflector->getMethod('setUrl');
        $setUrl->setAccessible(true);
        $setUrl->invokeArgs($testedClass, ['https://viacep.com.br/ws/74915380/json']);

        $return = $sendRequest->invokeArgs($testedClass, [
            RequestAbstract::HTTP_GET
        ]);

        self::assertIsArray($return);
        self::assertNotNull($return);
        self::assertEquals(200, $return['statusCode']);
    }

    public function testSendRequestCurlError()
    {
        $this->expectException(GetnetException::class);
        $this->expectExceptionCode(RequestAbstract::CURL_ERROR_CODE);
        $this->expectExceptionMessage('cURL error: ');

        $testedClass = $this->getMockForAbstractClass(RequestAbstract::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $sendRequest = $reflector->getMethod('sendRequest');
        $sendRequest->setAccessible(true);

        $setUrl = $reflector->getMethod('setUrl');
        $setUrl->setAccessible(true);
        $setUrl->invokeArgs($testedClass, ['']);

        $sendRequest->invokeArgs($testedClass, [
            RequestAbstract::HTTP_GET
        ]);
    }

}
