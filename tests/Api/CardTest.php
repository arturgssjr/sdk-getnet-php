<?php

namespace GetnetTests\Api;

use Getnet\Api\Card;
use Getnet\Api\Customer;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    private $data;
    private $card;
    private $customer;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->customer = new Customer();
        $this->card = new Card($this->customer);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->customer);
        unset($this->card);
    }

    public function testSetAndGetBrand()
    {
        $this->card->setBrand($this->data['card']['brand']);

        self::assertEquals($this->data['card']['brand'], $this->card->getBrand());
    }

    public function testSetAndGetCardNumber()
    {
        $this->card->setCardNumber($this->data['card']['cardNumber']);

        self::assertEquals($this->data['card']['cardNumber'], $this->card->getCardNumber());
    }

    public function testSetAndGetCardholderName()
    {
        $this->card->setCardholderName($this->data['card']['cardholderName']);

        self::assertEquals($this->data['card']['cardholderName'], $this->card->getCardholderName());
    }

    public function testSetAndGetExpirationMonth()
    {
        $this->card->setExpirationMonth($this->data['card']['expirationMonth']);

        self::assertEquals($this->data['card']['expirationMonth'], $this->card->getExpirationMonth());
    }

    public function testSetAndGetExpirationYear()
    {
        $this->card->setExpirationYear($this->data['card']['expirationYear']);

        self::assertEquals($this->data['card']['expirationYear'], $this->card->getExpirationYear());
    }

    public function testSetAndGetCardholderIdentification()
    {
        $this->card->setCardholderIdentification($this->data['card']['cardholderIdentification']);

        self::assertEquals($this->data['card']['cardholderIdentification'], $this->card->getCardholderIdentification());
    }

    public function testSetAndGetSecurityCode()
    {
        $this->card->setSecurityCode($this->data['card']['securityCode']);

        self::assertEquals($this->data['card']['securityCode'], $this->card->getSecurityCode());
    }

    public function testGetCustomer()
    {
        self::assertNotNull($this->card->getCustomer());
        self::assertInstanceOf(Customer::class, $this->card->getCustomer());
    }
}
