<?php
namespace GetnetTests\Api;

use Getnet\Api\Card;
use Getnet\Api\Customer;
use Getnet\Api\TokenCard;
use Getnet\Api\VaultCard;
use PHPUnit\Framework\TestCase;

class VaultCardTest extends TestCase
{
    private $data;
    private $card;
    private $customer;
    private $tokenCard;
    private $vaultCard;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->customer = new Customer();
        $this->card = new Card($this->customer);
        $this->tokenCard = new TokenCard($this->card);
        $this->vaultCard = new VaultCard($this->tokenCard);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->card);
        unset($this->customer);
        unset($this->tokenCard);
        unset($this->vaultCard);
    }

    public function testSetAndGetCard()
    {
        $this->vaultCard->setCards($this->data['vaultCard']['cards']);

        self::assertEquals($this->data['vaultCard']['cards'], $this->vaultCard->getCards());
    }

    public function testSetAndGetTokenCard()
    {
        $this->vaultCard->setTokenCard($this->tokenCard);

        self::assertNotNull($this->vaultCard->getTokenCard());
        self::assertInstanceOf(TokenCard::class, $this->vaultCard->getTokenCard());     
    }
}