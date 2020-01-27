<?php
namespace GetnetTests\Api;

use Getnet\Api\Card;
use Getnet\Api\Customer;
use Getnet\Api\TokenCard;
use PHPUnit\Framework\TestCase;

class TokenCardTest extends TestCase
{
    private $data;
    private $card;
    private $customer;
    private $tokenCard;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->customer = new Customer();
        $this->card = new Card($this->customer);
        $this->tokenCard = new TokenCard($this->card);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->card);
        unset($this->customer);
        unset($this->tokenCard);
    }

    public function testSetAndGetTokenNumber()
    {
        $this->tokenCard->setTokenNumber($this->data['tokenCard']['number_token']);

        self::assertEquals($this->data['tokenCard']['number_token'], $this->tokenCard->getTokenNumber());
    }

    public function testGetCard()
    {
        self::assertNotNull($this->tokenCard->getCard());
        self::assertInstanceOf(Card::class, $this->tokenCard->getCard());
    }
}
