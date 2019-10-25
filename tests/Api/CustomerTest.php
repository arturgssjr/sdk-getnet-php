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
        $this->customer->setCustomerId($this->data['customerId']);

        self::assertEquals($this->data['customerId'], $this->customer->getCustomerId());
    }

    public function testSetAndGetObservation()
    {
        $this->customer->setObservation($this->data['observation']);
        
        self::assertEquals($this->data['observation'], $this->customer->getObservation());
    }

    public function testSetAndGetFirstName()
    {
        $this->customer->setFirstName($this->data['firstName']);
        
        self::assertEquals($this->data['firstName'], $this->customer->getFirstName());
    }

    public function testSetAndGetEmail()
    {
        $this->customer->setEmail($this->data['email']);
        
        self::assertEquals($this->data['email'], $this->customer->getEmail());
    }

    public function testSetAndGetCellphoneNumber()
    {
        $this->customer->setCellphoneNumber($this->data['cellphoneNumber']);
        
        self::assertEquals($this->data['cellphoneNumber'], $this->customer->getCellphoneNumber());
    }

    public function testSetAndGetBirthDate()
    {
        $this->customer->setBirthDate($this->data['birthDate']);

        self::assertEquals($this->data['birthDate'], $this->customer->getBirthDate());
    }

    public function testSetAndGetPhoneNumber()
    {
        $this->customer->setPhoneNumber($this->data['phoneNumber']);

        self::assertEquals($this->data['phoneNumber'], $this->customer->getPhoneNumber());
    }

    public function testSetAndGetLastName()
    {
        $this->customer->setLastName($this->data['lastName']);

        self::assertEquals($this->data['lastName'], $this->customer->getLastName());
    }

    public function testSetAndGetDocumentType()
    {
        $this->customer->setDocumentType($this->data['documentType']);

        self::assertEquals($this->data['documentType'], $this->customer->getDocumentType());
    }

    public function testSetAndGetDocumentNumber()
    {
        $this->customer->setDocumentNumber($this->data['documentNumber']);

        self::assertEquals($this->data['documentNumber'], $this->customer->getDocumentNumber());
    }
}
