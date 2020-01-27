<?php

namespace Getnet\Api\Requests;

class AuthenticationRequest extends RequestAbstract
{
    const URI = 'auth/oauth/v2/token';
    const SCOPE = 'oob';
    const GRANT_TYPE = 'client_credentials';
    const CONTENT_TYPE = 'application/x-www-form-urlencoded';

    public function getAuthorization()
    {
        if (!$this->getAuthentication()->getAuthorization()) {
            $this->setMethod(RequestAbstract::HTTP_POST)
                ->setUrl($this->getEnvironment()->getUrl() . self::URI)
                ->setContent(
                    http_build_query([
                        'scope' => self::SCOPE,
                        'grant_type' => self::GRANT_TYPE
                    ])
                )
                ->setHeaders([
                    'Content-Type' => self::CONTENT_TYPE,
                    'Authorization' => $this->getAuthentication()->getAuthString(),
                ]);

            $authorization = $this->sendRequest();

            $this->getAuthentication()->setAuthorization($authorization);

            return $this->getAuthentication()->getAuthorization();
        } else {
            return $this->getAuthentication()->getAuthorization();
        }
    }
}