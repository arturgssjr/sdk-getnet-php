<?php

namespace GetnetTests\Api\Requests;

use Getnet\Api\Authentication;
use Getnet\Api\Card;
use Getnet\Api\Customer;
use Getnet\Api\Environment;
use Getnet\Api\Requests\TokenCardRequest;
use Getnet\Api\Seller;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

class TokenCardRequestTest extends TestCase
{
    private $data;
    private $card;
    private $seller;
    private $customer;
    private $environment;
    private $authentication;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->environment = new Environment();
        $this->seller = new Seller($this->data['seller']['client_id'], $this->data['seller']['secret_id'], $this->data['seller']['seller_id']);
        $this->authentication = new Authentication($this->seller);
        $this->customer = new Customer();
        $this->customer->setCustomerId($this->data['customer']['customer_id']);
        $this->card = new Card($this->customer);
        $this->card->setCardNumber($this->data['card']['card_number']);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->card);
        unset($this->seller);
        unset($this->customer);
        unset($this->authentication);
    }

    public function testGetTokenCardSuccess()
    {
        $testedClass = $this->getMockForAbstractClass(TokenCardRequest::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $getTokenCard = $reflector->getMethod('getTokenCard');

        $return = $getTokenCard->invokeArgs($testedClass, [
            $this->card,
        ]);

        $this->assertNotNull($return);
        $this->assertObjectHasAttribute('tokenNumber', $return);
        $this->assertEquals(128, strlen($return->getTokenNumber()));
    }
}
