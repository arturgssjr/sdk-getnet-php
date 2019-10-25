<?php
namespace Getnet\Api;

class Seller
{
    private $clientId;
    private $secretId;
    private $sellerId;

    /**
     * Seller constructor.
     * @param $clientId
     * @param $secretId
     * @param $sellerId
     */
    public function __construct($clientId, $secretId, $sellerId)
    {
        $this->clientId = $clientId;
        $this->secretId = $secretId;
        $this->sellerId = $sellerId;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     * @return Seller
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecretId()
    {
        return $this->secretId;
    }

    /**
     * @param mixed $secretId
     * @return Seller
     */
    public function setSecretId($secretId)
    {
        $this->secretId = $secretId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }

    /**
     * @param mixed $sellerId
     * @return Seller
     */
    public function setSellerId($sellerId)
    {
        $this->sellerId = $sellerId;
        return $this;
    }
}