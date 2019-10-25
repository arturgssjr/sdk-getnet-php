<?php

namespace GetnetTests\Api;

use Getnet\Api\Address;
use Getnet\Api\Customer;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    private $data;
    private $address;
    private $customer;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs'];
        $this->customer = new Customer();
        $this->address = new Address($this->customer);
    }

    protected function tearDown(): void
    {
        unset($this->data);
        unset($this->customer);
        unset($this->address);
    }

    public function testSetAndGetCountry()
    {
        $this->address->setCountry($this->data['address']['country']);

        self::assertEquals($this->data['address']['country'], $this->address->getCountry());
    }

    public function testSetAndGetCity()
    {
        $this->address->setCity($this->data['address']['city']);

        self::assertEquals($this->data['address']['city'], $this->address->getCity());
    }

    public function testSetAndGetComplement()
    {
        $this->address->setComplement($this->data['address']['complement']);

        self::assertEquals($this->data['address']['complement'], $this->address->getComplement());
    }

    public function testSetAndGetDistrict()
    {
        $this->address->setDistrict($this->data['address']['district']);

        self::assertEquals($this->data['address']['district'], $this->address->getDistrict());
    }

    public function testSetAndGetState()
    {
        $this->address->setState($this->data['address']['state']);

        self::assertEquals($this->data['address']['state'], $this->address->getState());
    }

    public function testSetAndGetNumber()
    {
        $this->address->setNumber($this->data['address']['number']);

        self::assertEquals($this->data['address']['number'], $this->address->getNumber());
    }

    public function testSetAndGetStreet()
    {
        $this->address->setStreet($this->data['address']['street']);

        self::assertEquals($this->data['address']['street'], $this->address->getStreet());
    }

    public function testSetAndGetPostalCode()
    {
        $this->address->setPostalCode($this->data['address']['postalCode']);

        self::assertEquals($this->data['address']['postalCode'], $this->address->getPostalCode());
    }

    public function testGetCustomer()
    {
        self::assertNotNull($this->address->getCustomer());
        self::assertInstanceOf(Customer::class, $this->address->getCustomer());
    }
}
