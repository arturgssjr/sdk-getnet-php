<?php
namespace Getnet\Api\Requests;

use Getnet\Api\Customer;
use Getnet\Api\TokenCard;
use Getnet\Api\VaultCard;

class VaultCardRequest extends RequestAbstract
{
    const URI = 'v1/cards';
    const CONTENT_TYPE = 'application/json';
    const STATUS_ALL = 'all';
    const STATUS_ACTIVE = 'active';
    const STATUS_RENEWED = 'renewed';

    /**
     * @var VaultCard
     */
    private $vaultCard;

    public function postVaultCard(TokenCard $tokenCard)
    {
        $this->vaultCard = new VaultCard($tokenCard);
        
        $this->_getAuthorization();

        $this->setUrl($this->getEnvironment()->getUrl() . self::URI);
        $this->setContent(
            json_encode([
                'number_token' => $this->vaultCard->getTokenCard()->getTokenNumber(),
                'brand' => $this->vaultCard->getTokenCard()->getCard()->getBrand(),
                'cardholder_name' => $this->vaultCard->getTokenCard()->getCard()->getCardholderName(),
                'expiration_month' => $this->vaultCard->getTokenCard()->getCard()->getExpirationMonth(),
                'expiration_year' => $this->vaultCard->getTokenCard()->getCard()->getExpirationYear(),
                'customer_id' => $this->vaultCard->getTokenCard()->getCard()->getCustomer()->getCustomerId(),
                'cardholder_identification' => $this->vaultCard->getTokenCard()->getCard()->getCardholderIdentification(),
                'verify_card' => false, //refatorar
                'security_code' => $this->vaultCard->getTokenCard()->getCard()->getSecurityCode(),
            ])
        );
        $this->setHeaders([
            'Content-Type' => self::CONTENT_TYPE,
            'Authorization' => $this->getAuthentication()->getAuthorizationToken(),
            'seller_id' => $this->getAuthentication()->getSeller()->getSellerId(),
        ]);

        $cardVault = $this->sendRequest(RequestAbstract::HTTP_POST);
        
        return $this->vaultCard->setCardId($cardVault['card_id']);
    }

    public function getVaultCard(string $customerId = '', string $status = '', string $cardId = '')
    {
        $this->_getAuthorization();

        if (!empty($cardId)) {
            $this->setUrl($this->getEnvironment()->getUrl() . self::URI . DIRECTORY_SEPARATOR . $cardId);
        }

        if (!empty($customerId) && !empty($status)) {
            $this->setUrl($this->getEnvironment()->getUrl() . self::URI . '?' . http_build_query([
                'customer_id' => $customerId,
                'status' => $status
            ]));
        }

        if (!empty($customerId)) {
            $this->setUrl($this->getEnvironment()->getUrl() . self::URI . '?' . http_build_query([
                'customer_id' => $customerId,
            ]));
        }

        $this->setHeaders([
            'Authorization' => $this->getAuthentication()->getAuthorizationToken(),
            'seller_id' => $this->getAuthentication()->getSeller()->getSellerId(),
        ]);

        $cardVault = $this->sendRequest(RequestAbstract::HTTP_GET);
    }

}