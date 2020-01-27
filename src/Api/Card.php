<?php

namespace Getnet\Api;

class Card
{
    const BRAND_ELO         = "Elo";
    const BRAND_AMEX        = "Amex";
    const BRAND_VISA        = "Visa";
    const BRAND_HIPERCARD   = "Hipercard";
    const BRAND_MASTERCARD  = "Mastercard";

    private $brand;
    private $cardNumber;
    private $cardholderName;
    private $expirationMonth;
    private $expirationYear;
    private $cardholderIdentification;
    private $securityCode;
    /**
     * @var Customer
     */
    private $customer;

    /**
     * Card constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     * @return Card
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param mixed $cardNumber
     * @return Card
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardholderName()
    {
        return $this->cardholderName;
    }

    /**
     * @param mixed $cardholderName
     * @return Card
     */
    public function setCardholderName($cardholderName)
    {
        $this->cardholderName = $cardholderName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    /**
     * @param mixed $expirationMonth
     * @return Card
     */
    public function setExpirationMonth($expirationMonth)
    {
        $this->expirationMonth = $expirationMonth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    /**
     * @param mixed $expirationYear
     * @return Card
     */
    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = $expirationYear;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardholderIdentification()
    {
        return $this->cardholderIdentification;
    }

    /**
     * @param mixed $cardholderIdentification
     * @return Card
     */
    public function setCardholderIdentification($cardholderIdentification)
    {
        $this->cardholderIdentification = $cardholderIdentification;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }

    /**
     * @param mixed $securityCode
     * @return Card
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;
        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}