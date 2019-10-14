<?php

namespace GetnetTests\Api;

use Getnet\Api\Authentication;
use Getnet\Api\Seller;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    private $data;
    private $seller;
    private $authentication;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->seller = new Seller($this->data['seller']['client_id'], $this->data['seller']['secret_id'], $this->data['seller']['seller_id']);
        $this->authentication = new Authentication($this->seller);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->seller);
        unset($this->authentication);
    }

    public function testGetAuthenticationString()
    {
        $sellerData = $this->data['seller'];
        $authString = 'Basic ' . base64_encode("{$sellerData['client_id']}:{$sellerData['secret_id']}");

        $this->assertEquals($authString, $this->authentication->getAuthentication());
    }

    public function testSetAndGetSeller()
    {
        $this->authentication->setSeller($this->seller);

        $this->assertEquals($this->seller, $this->authentication->getSeller());
    }
}