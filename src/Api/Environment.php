<?php
namespace Getnet\Api;

class Environment
{
    const STAGGING      = 'S';
    const PRODUCTION    = 'P';
    const URLS = [
        self::STAGGING   => 'https://api-homologacao.getnet.com.br/',
        self::PRODUCTION => 'https://api.getnet.com.br/',
    ];

    private $environment;

    public function __construct($environment = self::STAGGING)
    {
        $this->setEnvironment($environment);
    }

    public function getUrl()
    {
        return self::URLS[$this->getEnvironment()];
    }

    /**
     * Get the value of environment
     */ 
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set the value of environment
     *
     * @param $environment
     * @return  self
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }
}