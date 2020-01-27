<?php
namespace Getnet\Api;

class Environment
{
    const STAGGING   = 'STAGGING';
    const PRODUCTION = 'PRODUCTION';
    const SANDBOX    = 'SANDBOX';
    const URLS = [
        self::STAGGING   => 'https://api-homologacao.getnet.com.br/',
        self::PRODUCTION => 'https://api.getnet.com.br/',
        self::SANDBOX    => 'https://api-sandbox.getnet.com.br',
    ];

    private $environment;

    public function __construct($environment = self::STAGGING)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     * @return Environment
     */
    public function setEnvironment(string $environment): Environment
    {
        $this->environment = $environment;
        return $this;
    }

    public function getUrl()
    {
        return self::URLS[$this->getEnvironment()];
    }
}