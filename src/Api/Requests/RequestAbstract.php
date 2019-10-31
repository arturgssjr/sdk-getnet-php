<?php

namespace Getnet\Api\Requests;

use Getnet\Api\Environment;
use Getnet\Api\Authentication;
use Getnet\Api\Utils\CurlUtil;
use Getnet\Api\Utils\JsonUtil;
use Getnet\Api\Utils\ArrayUtil;
use Getnet\Api\Exceptions\GetnetException;
use Getnet\Api\Requests\AuthenticationRequest;

abstract class RequestAbstract
{

    const HTTP_PUT = 'PUT';
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_PATCH = 'PATCH';
    const HTTP_DELETE = 'DELETE';
    const CURL_ERROR_CODE = 0;

    private $environment;
    private $authentication;

    private $url;
    private $method = self::HTTP_GET;
    private $headers;
    private $content;

    public function __construct(Authentication $authentication, Environment $environment)
    {
        $this->environment = $environment;
        $this->authentication = $authentication;
    }

    /**
     * @return Authentication
     */
    public function getAuthentication(): Authentication
    {
        return $this->authentication;
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    protected function sendRequest()
    {
        $curl = curl_init($this->getUrl());

        $defaultCurlOptions = [
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING       => '',
        ];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->getMethod());
        empty($this->getContent()) ?: curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getContent());
        empty($this->getHeaders()) ?: curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());

        curl_setopt_array($curl, $defaultCurlOptions);

        $response = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            throw new GetnetException('cURL error: ' . CurlUtil::getCurlErrnoDescription(curl_errno($curl)), self::CURL_ERROR_CODE);
        }

        curl_close($curl);

        return $this->readResponse($statusCode, $response);
    }
    
    protected function readResponse($statusCode, $response)
    {
        $unserialized = JsonUtil::unserialize($response);

        switch ($statusCode) {
            case 200 :
            case 201 :
            case 202 :
                $unserialized['status_code'] = $statusCode;
                return $unserialized;
            case 204 :
                return $statusCode;
            default:
                $message = (is_array($unserialized) ? (isset($unserialized['error_description']) ? $unserialized['error_description'] : $unserialized['message']) : $unserialized);
                $details = (isset($unserialized['details']) ? $unserialized['details'] : []);
                throw new GetnetException($message, $statusCode, null, $details);
        }
    }

    protected function _getAuthorization()
    {
        if (!$this->getAuthentication()->getAuthorization()) {
            (new AuthenticationRequest($this->getAuthentication(), $this->getEnvironment()))->getAuthorization();
        }
    }

    /**
     * Get the value of url
     */ 
    protected function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */ 
    protected function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of headers
     */ 
    protected function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the value of headers
     *
     * @return  self
     */ 
    protected function setHeaders($headers)
    {
        $this->headers = ArrayUtil::convertArrayToHeader($headers);

        return $this;
    }

    /**
     * Get the value of content
     */ 
    protected function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    protected function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of method
     */ 
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the value of method
     *
     * @return  self
     */ 
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }
}
