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

    public function testSetAndGetAuthorization()
    {
        $this->authentication->setAuthorization($this->data['authorization']);

        self::assertNotNull($this->authentication->getAuthorization());
        self::assertArrayHasKey('access_token', $this->authentication->getAuthorization());
        self::assertArrayHasKey('token_type', $this->authentication->getAuthorization());
        self::assertArrayHasKey('expires_in', $this->authentication->getAuthorization());
        self::assertArrayHasKey('scope', $this->authentication->getAuthorization());
    }

    public function testGetAuthenticationString()
    {
        $authString = 'Basic ' . base64_encode("{$this->data['seller']['client_id']}:{$this->data['seller']['secret_id']}");

        self::assertEquals($authString, $this->authentication->getAuthString());
    }

    public function testGetSeller()
    {
        self::assertNotNull($this->authentication->getSeller());
        self::assertEquals($this->seller, $this->authentication->getSeller());
        self::assertInstanceOf(Seller::class, $this->authentication->getSeller());
    }
}