<?php

namespace Getnet\Api\Requests;

use Getnet\Api\Authentication;
use Getnet\Api\Environment;
use Getnet\Api\Exceptions\GetnetException;
use Getnet\Api\Seller;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionObject;

class AuthenticationRequestTest extends TestCase
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

    public function testGetAuthenticationSuccess()
    {
        $testedClass = $this->getMockForAbstractClass(AuthenticationRequest::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('getAuthorization');

        $return = $method->invoke($testedClass);

        self::assertIsArray($return);
        self::assertNotNull($return);
        self::assertEquals(200, $return['statusCode']);
        self::assertArrayHasKey('access_token', $return);
        self::assertArrayHasKey('token_type', $return);
        self::assertArrayHasKey('expires_in', $return);
        self::assertArrayHasKey('scope', $return);
    }

    public function testGetNewAuthenticationSuccess()
    {
        $authentication = clone $this->authentication;
        $authentication->setAuthorization($this->data['authorization']);

        $testedClass = $this->getMockForAbstractClass(AuthenticationRequest::class, [
            $authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('getAuthorization');

        $return = $method->invoke($testedClass);

        self::assertIsArray($return);
        self::assertNotNull($return);
        self::assertEquals(200, $return['statusCode']);
        self::assertArrayHasKey('access_token', $return);
        self::assertArrayHasKey('token_type', $return);
        self::assertArrayHasKey('expires_in', $return);
        self::assertArrayHasKey('scope', $return);
    }

    public function testGetAuthenticationFail()
    {
        $this->expectException(GetnetException::class);
        $this->expectExceptionCode(401);
        $this->expectExceptionMessage('The given client credentials were not valid');

        $seller = clone $this->seller;
        $seller->setClientId('CLIENT_ID');

        $this->authentication->setSeller($seller);

        $testedClass = $this->getMockForAbstractClass(AuthenticationRequest::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('getAuthorization');

        $method->invoke($testedClass);
    }
}
