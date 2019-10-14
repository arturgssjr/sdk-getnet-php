<?php
namespace Getnet\Api;


class CardTokenization
{
    private $cardNumber;
    private $customerId;
    private $tokenNumber;

    /**
     * CardTokenization constructor.
     * @param $cardNumber
     * @param $customerId
     */
    public function __construct($cardNumber, $customerId)
    {
        $this->setCardNumber($cardNumber);
        $this->setCustomerId($customerId);
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
     * @return CardTokenization
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     * @return CardTokenization
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTokenNumber()
    {
        return $this->tokenNumber;
    }

    /**
     * @param mixed $tokenNumber
     * @return CardTokenization
     */
    public function setTokenNumber($tokenNumber)
    {
        $this->tokenNumber = $tokenNumber;
        return $this;
    }
}