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

        $this->assertEquals(200, $return['statusCode']);
        $this->assertIsArray($return);
        $this->assertArrayHasKey('access_token', $return);
        $this->assertArrayHasKey('token_type', $return);
        $this->assertArrayHasKey('expires_in', $return);
        $this->assertArrayHasKey('scope', $return);

        return $return;
    }

    /**
     * @depends testGetAuthenticationSuccess
     * @param array $authorizationToken
     * @throws ReflectionException
     */
    public function testGetAuthenticationSuccessNotExpired(array $authorizationToken)
    {
        $this->authentication->setAuthorization($authorizationToken);

        $testedClass = $this->getMockForAbstractClass(AuthenticationRequest::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('getAuthorization');

        $return = $method->invoke($testedClass);

        $this->assertEquals(200, $return['statusCode']);
        $this->assertIsArray($return);
        $this->assertArrayHasKey('access_token', $return);
        $this->assertArrayHasKey('token_type', $return);
        $this->assertArrayHasKey('expires_in', $return);
        $this->assertArrayHasKey('scope', $return);
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

    /**
     * @depends testGetAuthenticationSuccess
     * @param array $authorizationToken
     */
    public function testGetAuthorizationSuccess(array $authorizationToken)
    {
        $this->authentication->setAuthorization($authorizationToken);

        $token = $this->authentication->getAuthorization();

        $this->assertEquals($authorizationToken, $token);
    }

    /**
     * @depends testGetAuthenticationSuccess
     * @param array $authorizationToken
     */
    public function testGetAuthorizationExpired(array $authorizationToken)
    {
        $authorizationToken['expires_in'] = 59;

        $this->authentication->setAuthorization($authorizationToken);

        $this->assertNull($this->authentication->getAuthorization());
    }

    /**
     * @depends testGetAuthenticationSuccess
     * @param array $authorizationToken
     */
    public function testGetAuthorizationToken(array $authorizationToken)
    {
        $this->authentication->setAuthorization($authorizationToken);

        $token = $authorizationToken['token_type'] . ' ' . $authorizationToken['access_token'];

        $this->assertStringContainsString($authorizationToken['token_type'], $this->authentication->getAuthorizationToken());
        $this->assertStringContainsString($authorizationToken['access_token'], $this->authentication->getAuthorizationToken());
        $this->assertEquals($token, $this->authentication->getAuthorizationToken());
    }
}
