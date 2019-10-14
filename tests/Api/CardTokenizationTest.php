<?php
namespace GetnetTests\Api;

use Getnet\Api\CardTokenization;
use PHPUnit\Framework\TestCase;

class CardTokenizationTest extends TestCase
{
    private $data;
    private $cardTokenization;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->cardTokenization = new CardTokenization($this->data['cardTokenization']['cardNumber'], $this->data['cardTokenization']['customerId']);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->cardTokenization);
    }

    public function testSetAndGetCardNumber()
    {
        $this->cardTokenization->setCustomerId($this->data['cardTokenization']['cardNumber']);

        $this->assertEquals($this->data['cardTokenization']['cardNumber'], $this->cardTokenization->getCardNumber());
    }

    public function testSetAndGetCustomerId()
    {
        $this->cardTokenization->setCustomerId($this->data['cardTokenization']['customerId']);

        $this->assertEquals($this->data['cardTokenization']['customerId'], $this->cardTokenization->getCustomerId());
    }
}
