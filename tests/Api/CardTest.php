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
        $this->card->setCardNumber($this->data['card']['card_number']);

        self::assertEquals($this->data['card']['card_number'], $this->card->getCardNumber());
    }

    public function testSetAndGetCardholderName()
    {
        $this->card->setCardholderName($this->data['card']['cardholder_name']);

        self::assertEquals($this->data['card']['cardholder_name'], $this->card->getCardholderName());
    }

    public function testSetAndGetExpirationMonth()
    {
        $this->card->setExpirationMonth($this->data['card']['expiration_month']);

        self::assertEquals($this->data['card']['expiration_month'], $this->card->getExpirationMonth());
    }

    public function testSetAndGetExpirationYear()
    {
        $this->card->setExpirationYear($this->data['card']['expiration_year']);

        self::assertEquals($this->data['card']['expiration_year'], $this->card->getExpirationYear());
    }

    public function testSetAndGetCardholderIdentification()
    {
        $this->card->setCardholderIdentification($this->data['card']['cardholder_identification']);

        self::assertEquals($this->data['card']['cardholder_identification'], $this->card->getCardholderIdentification());
    }

    public function testSetAndGetSecurityCode()
    {
        $this->card->setSecurityCode($this->data['card']['security_code']);

        self::assertEquals($this->data['card']['security_code'], $this->card->getSecurityCode());
    }

    public function testGetCustomer()
    {
        self::assertNotNull($this->card->getCustomer());
        self::assertInstanceOf(Customer::class, $this->card->getCustomer());
    }
}
