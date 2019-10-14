<?php
namespace Getnet\Api;

use Getnet\Api\Requests\AuthenticationRequest;

class Authentication
{
    private $seller;
    private $authorization;

    public function __construct(Seller $seller)
    {
        $this->setSeller($seller);
    }

    public function getAuthentication()
    {
        return 'Basic ' . base64_encode($this->getSeller()->getClientId() . ':' . $this->getSeller()->getSecretId());
    }

    /**
     * Get the value of seller
     */ 
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Set the value of seller
     *
     * @param $seller
     * @return  self
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;
        return $this;
    }

    /**
     * Get the value of authorization
     */ 
    public function getAuthorization()
    {
        if (time() >= ($this->authorization['timestamp'] + $this->authorization['expires_in'] - AuthenticationRequest::SECURITY_TIME)) {
            $this->authorization = null;
        }
        return $this->authorization;
    }

    /**
     * Set the value of authorization
     *
     * @param $authorization
     * @return  self
     */
    public function setAuthorization(array $authorization)
    {
        $this->authorization = $authorization;

        if (!empty($this->authorization)) {
            $this->authorization['timestamp'] = time();
        }

        return $this;
    }

    public function getAuthorizationToken()
    {
        if (!isset($this->getAuthorization()['access_token']) || !isset($this->getAuthorization()['token_type'])) {
            return null;
        }
        return $this->getAuthorization()['token_type'] . ' ' . $this->getAuthorization()['access_token'];
    }
}