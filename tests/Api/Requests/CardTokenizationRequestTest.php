<?php

namespace GetnetTests\Api\Requests;

use Getnet\Api\Authentication;
use Getnet\Api\Environment;
use Getnet\Api\Exceptions\GetnetException;
use Getnet\Api\Requests\CardTokenizationRequest;
use Getnet\Api\Seller;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

class CardTokenizationRequestTest extends TestCase
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
        unset($this->seller);
        unset($this->authentication);
    }

    public function testGetCardTokenSuccess()
    {
        $testedClass = $this->getMockForAbstractClass(CardTokenizationRequest::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('getCardToken');

        $return = $method->invokeArgs($testedClass, [
            $this->data['cardTokenization']['cardNumber'],
            $this->data['cardTokenization']['customerId'],
        ]);

        $this->assertNotNull($return);
        $this->assertObjectHasAttribute('tokenNumber', $return);
        $this->assertEquals(128, strlen($return->getTokenNumber()));
    }

//    public function testGetCardTokenFail()
//    {
//        $this->expectException(GetnetException::class);
//        $this->expectExceptionCode(400);
//        $this->expectExceptionMessage('Invalid Token Card');
//
//        $testedClass = $this->getMockForAbstractClass(CardTokenizationRequest::class, [
//            $this->authentication,
//            $this->environment,
//        ]);
//
//        $reflector = new ReflectionObject($testedClass);
//
//        $method = $reflector->getMethod('getCardToken');
//
//        $method->invokeArgs($testedClass, [
//            $this->data['cardTokenization'  ]['cardNumber'],
//            $this->data['cardTokenization']['customerId'],
//        ]);
//    }
}
