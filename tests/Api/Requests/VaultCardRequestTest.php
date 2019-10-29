<?php
namespace GetnetTests\Api\Requests;

use Getnet\Api\Card;
use ReflectionObject;
use Getnet\Api\Seller;
use Getnet\Api\Customer;
use Getnet\Api\TokenCard;
use Getnet\Api\Environment;
use Getnet\Api\Authentication;
use PHPUnit\Framework\TestCase;
use Getnet\Api\Requests\TokenCardRequest;
use Getnet\Api\Requests\VaultCardRequest;

class VaultCardRequestTest extends TestCase
{
    private $data;
    private $card;
    private $seller;
    private $customer;
    private $tokenCard;
    private $environment;
    private $authentication;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->environment = new Environment();
        $this->seller = new Seller($this->data['seller']['client_id'], $this->data['seller']['secret_id'], $this->data['seller']['seller_id']);
        $this->authentication = new Authentication($this->seller);
        $this->customer = new Customer();
        $this->customer->setCustomerId($this->data['customer']['customerId']);
        $this->card = new Card($this->customer);
        $this->card->setCardNumber($this->data['card']['cardNumber']);
        $this->card->setExpirationMonth($this->data['card']['expirationMonth']);
        $this->card->setExpirationYear($this->data['card']['expirationYear']);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->card);
        unset($this->seller);
        unset($this->customer);
        unset($this->environment);
        unset($this->authentication);
    }

    public function testPostVaultCard()
    {
        $testedClass = $this->getMockForAbstractClass(VaultCardRequest::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('postVaultCard');

        $return = $method->invokeArgs($testedClass, [
            $this->getTokenCard(),
        ]);

        $this->assertNotNull($return);
        $this->assertObjectHasAttribute('cardId', $return);
        $this->assertEquals(36, strlen($return->getCardId()));
        $this->assertEquals(128, strlen($return->getTokenCard()->getTokenNumber()));
    }

    public function testPostVaultCardNewAccessToken()
    {
        $authentication = new Authentication($this->seller);
        $authentication->setAuthorization([]);

        $testedClass = $this->getMockForAbstractClass(VaultCardRequest::class, [
            $authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('postVaultCard');

        $return = $method->invokeArgs($testedClass, [
            $this->getTokenCard(),
        ]);

        $this->assertNotNull($return);
        $this->assertObjectHasAttribute('cardId', $return);
        $this->assertEquals(36, strlen($return->getCardId()));
        $this->assertEquals(128, strlen($return->getTokenCard()->getTokenNumber()));    
    }

    public function testGetVaultCard()
    {
        $testedClass = $this->getMockForAbstractClass(VaultCardRequest::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('getVaultCard');

        $return = $method->invokeArgs($testedClass, [
            $this->data['customer']['customerId']
        ]);

    }

    private function getTokenCard()
    {
        $testedClass = $this->getMockForAbstractClass(TokenCardRequest::class, [
            $this->authentication,
            $this->environment,
        ]);

        $reflector = new ReflectionObject($testedClass);

        $method = $reflector->getMethod('getTokenCard');

        $tokenCard = $method->invokeArgs($testedClass, [
            $this->card,
        ]);

        return $tokenCard;
    }
}