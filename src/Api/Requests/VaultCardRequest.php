<?php
namespace Getnet\Api\Requests;

use Getnet\Api\TokenCard;
use Getnet\Api\VaultCard;

class VaultCardRequest extends RequestAbstract
{
    const URI = 'v1/cards';
    const CONTENT_TYPE = 'application/json';

    /**
     * @var VaultCard
     */
    private $vaultCard;

    public function postVaultCard(TokenCard $tokenCard)
    {
        $this->vaultCard = new VaultCard($tokenCard);
        
        if (!$this->getAuthentication()->getAuthorization()) {
            (new AuthenticationRequest($this->getAuthentication(), $this->getEnvironment()))->getAuthorization();
        }

        $cardVault = $this->sendRequest(RequestAbstract::HTTP_POST);
        
        return $this->vaultCard->setCardId($cardVault['card_id']);
    }

    protected function _getUrl()
    {
        return $this->getEnvironment()->getUrl() . self::URI;
    }

    protected function _getContent()
    {
        return json_encode([
            'number_token' => $this->vaultCard->getTokenCard()->getTokenNumber(),
            'brand' => $this->vaultCard->getTokenCard()->getCard()->getBrand(),
            'cardholder_name' => $this->vaultCard->getTokenCard()->getCard()->getCardholderName(),
            'expiration_month' => $this->vaultCard->getTokenCard()->getCard()->getExpirationMonth(),
            'expiration_year' => $this->vaultCard->getTokenCard()->getCard()->getExpirationYear(),
            'customer_id' => $this->vaultCard->getTokenCard()->getCard()->getCustomer()->getCustomerId(),
            'cardholder_identification' => $this->vaultCard->getTokenCard()->getCard()->getCardholderIdentification(),
            'verify_card' => false, //refatorar
            'security_code' => $this->vaultCard->getTokenCard()->getCard()->getSecurityCode(),
        ]);
    }

    protected function _getHeader()
    {
        return [
            'Content-Type' => self::CONTENT_TYPE,
            'Authorization' => $this->getAuthentication()->getAuthorizationToken(),
            'seller_id' => $this->getAuthentication()->getSeller()->getSellerId(),
        ];
    }

}