<?php

namespace GetnetTest\Api;

use Getnet\Api\Seller;
use PHPUnit\Framework\TestCase;

class SellerTest extends TestCase
{
    private $data;
    private $seller;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->seller = new Seller($this->data['seller']['client_id'], $this->data['seller']['secret_id'], $this->data['seller']['seller_id']);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->seller);
    }

    public function testSetAndGetClientId()
    {
        $this->seller->setClientId($this->data['seller']['client_id']);

        $this->assertEquals($this->data['seller']['client_id'], $this->seller->getClientId());
    }

    public function testSetAndGetSellerId()
    {
        $this->seller->setSellerId($this->data['seller']['seller_id']);

        $this->assertEquals($this->data['seller']['seller_id'], $this->seller->getSellerId());
    }

    public function testSetAndGetSecretId()
    {
        $this->seller->setSecretId($this->data['seller']['secret_id']);

        $this->assertEquals($this->data['seller']['secret_id'], $this->seller->getSecretId());
    }
}
