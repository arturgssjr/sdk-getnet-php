<?php
namespace Getnet\Api;

class VaultCard
{
    private $cards;
    /**
     * @var TokenCard
     */
    private $tokenCard;

    /**
     * Get the value of card
     */ 
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Set the value of card
     *
     * @return  self
     */ 
    public function setCards($cards)
    {
        $this->cards = $cards;

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

    /**
     * Set the value of tokenCard
     *
     * @param  TokenCard  $tokenCard
     *
     * @return  self
     */ 
    public function setTokenCard(TokenCard $tokenCard)
    {
        $this->tokenCard = $tokenCard;

        return $this;
    }
}