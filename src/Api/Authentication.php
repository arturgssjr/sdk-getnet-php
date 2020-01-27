<?php
namespace Getnet\Api;

class Authentication
{
    private $authorization;
    /**
     * @var Seller
     */
    private $seller;

    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * @return mixed
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param mixed $authorization
     * @return Authentication
     */
    public function setAuthorization(array $authorization)
    {
        $this->authorization = $authorization;
        return $this;
    }

    /**
     * @return Seller
     */
    public function getSeller(): Seller
    {
        return $this->seller;
    }

    /**
     * @param Seller $seller
     * @return Authentication
     */
    public function setSeller(Seller $seller): Authentication
    {
        $this->seller = $seller;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthString()
    {
        return 'Basic ' . base64_encode("{$this->getSeller()->getClientId()}:{$this->getSeller()->getSecretId()}");
    }

    public function getAuthorizationToken()
    {
        return $this->getAuthorization()['token_type'] . ' ' . $this->getAuthorization()['access_token'];
    }
}