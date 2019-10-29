<?php

namespace Getnet\Api\Requests;

use Getnet\Api\Card;
use Getnet\Api\TokenCard;

class TokenCardRequest extends RequestAbstract
{
    const URI = 'v1/tokens/card';
    const CONTENT_TYPE = 'application/json';

    /**
     * @var TokenCard
     */
    private $tokenCard;

    public function getTokenCard(Card $card)
    {
        $this->tokenCard = new TokenCard($card);

        $this->setUrl($this->getEnvironment()->getUrl() . self::URI);

        $this->setContent(
            json_encode([
                'card_number' => $this->tokenCard->getCard()->getCardNumber(),
                'customer_id' => $this->tokenCard->getCard()->getCustomer()->getCustomerId(),
            ])
        );

        $this->setHeaders([
            'Content-Type' => self::CONTENT_TYPE,
            'Authorization' => $this->getAuthentication()->getAuthorizationToken(),
            'seller_id' => $this->getAuthentication()->getSeller()->getSellerId(),
        ]);

        $this->_getAuthorization();

        $cardToken = $this->sendRequest(RequestAbstract::HTTP_POST);

        return $this->tokenCard->setTokenNumber($cardToken['number_token']);
    }
}