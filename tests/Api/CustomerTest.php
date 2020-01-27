<?php

namespace GetnetTests\Api;

use Getnet\Api\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    private $data;
    private $customer;

    protected function setUp(): void
    {
        $this->data = $GLOBALS['configs']['customer'];
        $this->customer = new Customer();
    }

    protected function tearDown(): void
    {
        unset($this->data);
    }

    public function testSetAndGetCustomerId()
    {
        $this->customer->setCustomerId($this->data['customer_id']);

        self::assertEquals($this->data['customer_id'], $this->customer->getCustomerId());
    }

    public function testSetAndGetObservation()
    {
        $this->customer->setObservation($this->data['observation']);
        
        self::assertEquals($this->data['observation'], $this->customer->getObservation());
    }

    public function testSetAndGetFirstName()
    {
        $this->customer->setFirstName($this->data['first_name']);
        
        self::assertEquals($this->data['first_name'], $this->customer->getFirstName());
    }

    public function testSetAndGetEmail()
    {
        $this->customer->setEmail($this->data['email']);
        
        self::assertEquals($this->data['email'], $this->customer->getEmail());
    }

    public function testSetAndGetCellphoneNumber()
    {
        $this->customer->setCellphoneNumber($this->data['cellphone_number']);
        
        self::assertEquals($this->data['cellphone_number'], $this->customer->getCellphoneNumber());
    }

    public function testSetAndGetBirthDate()
    {
        $this->customer->setBirthDate($this->data['birth_date']);

        self::assertEquals($this->data['birth_date'], $this->customer->getBirthDate());
    }

    public function testSetAndGetPhoneNumber()
    {
        $this->customer->setPhoneNumber($this->data['phone_number']);

        self::assertEquals($this->data['phone_number'], $this->customer->getPhoneNumber());
    }

    public function testSetAndGetLastName()
    {
        $this->customer->setLastName($this->data['last_name']);

        self::assertEquals($this->data['last_name'], $this->customer->getLastName());
    }

    public function testSetAndGetDocumentType()
    {
        $this->customer->setDocumentType($this->data['document_type']);

        self::assertEquals($this->data['document_type'], $this->customer->getDocumentType());
    }

    public function testSetAndGetDocumentNumber()
    {
        $this->customer->setDocumentNumber($this->data['document_number']);

        self::assertEquals($this->data['document_number'], $this->customer->getDocumentNumber());
    }

    public function testSetAndGetBillingAddress()
    {
        $this->customer->setBillingAddress($this->data['address']);

        self::assertEquals($this->data['address'], $this->customer->getBillingAddress());
    }

    public function testSetAndGetShippingAddress()
    {
        $this->customer->setShippingAddress($this->data['address']);

        self::assertEquals($this->data['address'], $this->customer->getShippingAddress());
    }
}
