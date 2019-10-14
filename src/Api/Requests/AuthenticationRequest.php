<?php

namespace Getnet\Api\Requests;


use Getnet\Api\Authentication;
use Getnet\Api\Environment;

class AuthenticationRequest extends RequestAbstract
{
    const URI = 'auth/oauth/v2/token';
    const SCOPE = 'oob';
    const GRANT_TYPE = 'client_credentials';
    const CONTENT_TYPE = 'application/x-www-form-urlencoded';
    const SECURITY_TIME = 60;

    public function getAuthorization()
    {
        if (!$this->getAuthentication()->getAuthorizationToken()) {
            $authorization = $this->sendRequest(RequestAbstract::HTTP_POST);

            $this->getAuthentication()->setAuthorization($authorization);

            return $this->getAuthentication()->getAuthorization();
        } else {
            return $this->getAuthentication()->getAuthorization();
        }
    }

    protected function _getUrl()
    {
        return $this->getEnvironment()->getUrl() . self::URI;
    }

    protected function _getContent()
    {
        return http_build_query([
            'scope' => self::SCOPE,
            'grant_type' => self::GRANT_TYPE
        ]);
    }

    protected function _getHeader()
    {
        return [
            'Content-Type' => self::CONTENT_TYPE,
            'Authorization' => $this->getAuthentication()->getAuthentication(),
        ];
    }
}