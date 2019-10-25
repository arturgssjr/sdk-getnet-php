<?php

namespace Getnet\Api;

class TokenCard
{
    private $tokenNumber;
    /**
     * @var Card
     */
    private $card;

    /**
     * TokenCard constructor.
     * @param Card $card
     */
    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    /**
     * @return mixed
     */
    public function getTokenNumber()
    {
        return $this->tokenNumber;
    }

    /**
     * @param mixed $tokenNumber
     * @return TokenCard
     */
    public function setTokenNumber($tokenNumber)
    {
        $this->tokenNumber = $tokenNumber;
        return $this;
    }

    /**
     * @return Card
     */
    public function getCard(): Card
    {
        return $this->card;
    }
}