<?php
namespace Getnet\Api;

class Seller
{
    private $client_id;
    private $secret_id;
    private $seller_id;

    public function __construct($client_id, $secret_id, $seller_id)
    {
        $this->setClientId($client_id);
        $this->setSecretId($secret_id);
        $this->setSellerId($seller_id);
    }

    /**
     * Get the value of client_id
     */ 
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set the value of client_id
     *
     * @param $client_id
     * @return  self
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * Get the value of secret_id
     */ 
    public function getSecretId()
    {
        return $this->secret_id;
    }

    /**
     * Set the value of secret_id
     *
     * @param $secret_id
     * @return  self
     */
    public function setSecretId($secret_id)
    {
        $this->secret_id = $secret_id;

        return $this;
    }

    /**
     * Get the value of seller_id
     */ 
    public function getSellerId()
    {
        return $this->seller_id;
    }

    /**
     * Set the value of seller_id
     *
     * @param $seller_id
     * @return  self
     */
    public function setSellerId($seller_id)
    {
        $this->seller_id = $seller_id;

        return $this;
    }
}