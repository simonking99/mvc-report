<?php

namespace App\Card;

#Dice ärver från Card
class DeckOfCards extends Card
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_deck(): array
    {
        return $this->value;
    }

    public function shuffle_deck(): array
    {
        shuffle($this->value);
        return $this->value;
    }

    public function count(): int
    {
        return count($this->value);
    }
}
