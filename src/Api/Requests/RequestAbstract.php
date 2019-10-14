<?php

namespace Getnet\Api\Requests;

use Getnet\Api\Authentication;
use Getnet\Api\Environment;
use Getnet\Api\Exceptions\GetnetException;
use Getnet\Api\Helpers\ArrayUtil;
use Getnet\Api\Helpers\JsonUtil;

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
    private $curlOptions;

    public function __construct(Authentication $authentication, Environment $environment, array $curlOptions = [])
    {
        $this->setEnvironment($environment);
        $this->setAuthentication($authentication);
        $this->setCurlOptions($curlOptions);
    }


    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
        return $this;
    }

    public function getAuthentication()
    {
        return $this->authentication;
    }

    public function setAuthentication(Authentication $authentication)
    {
        $this->authentication = $authentication;
        return $this;
    }

    public function getCurlOptions()
    {
        return $this->curlOptions;
    }

    public function setCurlOptions($curlOptions)
    {
        $this->curlOptions = $curlOptions;
        return $this;
    }

    protected function sendRequest($method, $url = '', $content = NULL, array $headers = [])
    {
        $url = empty($url) ? $this->_getUrl() : $url;
        $content = empty($content) ? $this->_getContent() : $content;
        $headers = empty($headers) ? $this->_getHeader() : $headers;

        $curl = curl_init($url);

        $this->setCurlOptions([
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $content,
            CURLOPT_HTTPHEADER => ArrayUtil::convertArrayToHeader($headers),
            CURLOPT_ENCODING => '',
            CURLOPT_RETURNTRANSFER => true,
        ]);

        curl_setopt_array($curl, $this->getCurlOptions());

        $response = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            throw new GetnetException('Curl error: ' . curl_error($curl), self::CURL_ERROR_CODE);
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
                $unserialized['statusCode'] = $statusCode;
                return $unserialized;
            default:
                $message = (is_array($unserialized) ? (isset($unserialized['error_description']) ? $unserialized['error_description'] : $unserialized['message']) : $unserialized);
                $details = (isset($unserialized['details']) ? $unserialized['details'] : []);
                throw new GetnetException($message, $statusCode, null, $details);
        }
    }

    protected function _getUrl()
    {
        return '';
    }

    protected function _getContent()
    {
        return [];
    }

    protected function _getHeader()
    {
        return [];
    }
}
