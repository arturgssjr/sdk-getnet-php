<?php
namespace Getnet\Api\Requests;

use Getnet\Api\Customer;
use Getnet\Api\TokenCard;
use Getnet\Api\VaultCard;
use Getnet\Api\Environment;
use Getnet\Api\Authentication;
use Getnet\Api\Exceptions\GetnetException;

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

    public function __construct(VaultCard $vaultCard, Authentication $authentication, Environment $environment)
    {
        parent::__construct($authentication, $environment);
        $this->vaultCard = $vaultCard;
    }

    public function postVaultCard(TokenCard $tokenCard)
    {
        $this->_getAuthorization();

        $this->vaultCard->setTokenCard($tokenCard);

        $this->setMethod(RequestAbstract::HTTP_POST)
            ->setUrl($this->getEnvironment()->getUrl() . self::URI)
            ->setContent(
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
            )
            ->setHeaders([
                'Content-Type' => self::CONTENT_TYPE,
                'Authorization' => $this->getAuthentication()->getAuthorizationToken(),
                'seller_id' => $this->getAuthentication()->getSeller()->getSellerId(),
            ]);

        $cardVault = $this->sendRequest();
        
        return $cardVault;
    }

    public function getVaultCard(string $customerId = '', string $status = '', string $cardId = '')
    {
        $this->_getAuthorization();

        if (empty($customerId) && !empty($status)) {
            throw new GetnetException('Customer ID required.', 400);
        }

        if (!empty($customerId) && !empty($status)) {
            $this->setUrl($this->getEnvironment()->getUrl() . self::URI . '?' . http_build_query([
                'customer_id' => $customerId,
                'status' => $status,
            ]));
        } 
        
        if (!empty($customerId) && empty($status)) {
            $this->setUrl($this->getEnvironment()->getUrl() . self::URI . '?' . http_build_query([
                'customer_id' => $customerId,
            ]));
        }

        if (!empty($cardId)) {
            $this->setUrl($this->getEnvironment()->getUrl() . self::URI . DIRECTORY_SEPARATOR . $cardId);
        }

        $this->setHeaders([
            'Authorization' => $this->getAuthentication()->getAuthorizationToken(),
            'seller_id' => $this->getAuthentication()->getSeller()->getSellerId(),
        ]);
        
        $cardVault = $this->sendRequest();

        if (array_key_exists('cards', $cardVault)) {
            return $this->vaultCard->setCards($cardVault['cards']);
        }

        return $this->vaultCard->setCards($cardVault);
    }

    public function deleteVaultCard(string $cardId)
    {
        $this->_getAuthorization();

        $this->setMethod(RequestAbstract::HTTP_DELETE)
            ->setUrl($this->getEnvironment()->getUrl() . self::URI . DIRECTORY_SEPARATOR . $cardId)
            ->setHeaders([
                'Authorization' => $this->getAuthentication()->getAuthorizationToken(),
                'seller_id' => $this->getAuthentication()->getSeller()->getSellerId(),
            ]);

        return $this->sendRequest();
    }

}