<?php

namespace Getnet\Api\Requests;

use Getnet\Api\CardTokenization;
use Getnet\Api\Exceptions\GetnetException;

class CardTokenizationRequest extends RequestAbstract
{
    const URI = 'v1/tokens/card';
    const CONTENT_TYPE = 'application/json';

    private $authorization;

    /**
     * @var CardTokenization
     */
    private $cardTokenization;

    public function getAuthorization()
    {
        return $this->authorization;
    }

    public function setAuthorization($authorization)
    {
        $this->authorization = $authorization;
    }

    public function getCardToken($cardNumber, $customerId = null)
    {
        $this->cardTokenization = new CardTokenization($cardNumber, $customerId);

        if (!$this->getAuthentication()->getAuthorization()) {
            (new AuthenticationRequest($this->getAuthentication(), $this->getEnvironment()))->getAuthorization();
            $this->setAuthorization($this->getAuthentication()->getAuthorizationToken());
        }

        $cardToken = $this->sendRequest(RequestAbstract::HTTP_POST);

        return $this->cardTokenization->setTokenNumber($cardToken['number_token']);
    }

    protected function _getUrl()
    {
        return $this->getEnvironment()->getUrl() . self::URI;
    }

    protected function _getContent()
    {
        return json_encode([
            'card_number' => $this->cardTokenization->getCardNumber(),
            'customer_id' => $this->cardTokenization->getCustomerId(),
        ]);
    }

    protected function _getHeader()
    {
        return [
            'Content-Type' => self::CONTENT_TYPE,
            'Authorization' => $this->getAuthorization(),
            'seller_id' => $this->getAuthentication()->getSeller()->getSellerId(),
        ];
    }
}