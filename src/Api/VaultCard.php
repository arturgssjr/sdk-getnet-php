<?php
namespace Getnet\Api;

class VaultCard
{
    private $cardId;
    /**
     * @var TokenCard
     */
    private $tokenCard;

    public function __construct(TokenCard $tokenCard)
    {
        $this->tokenCard = $tokenCard;
    }

    /**
     * Get the value of cardId
     */ 
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set the value of cardId
     *
     * @return  self
     */ 
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get the value of tokenCard
     *
     * @return  TokenCard
     */ 
    public function getTokenCard()
    {
        return $this->tokenCard;
    }
}