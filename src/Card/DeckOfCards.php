<?php

namespace App\Card;

#Dice ärver från Card
class DeckOfCards extends Card
{
    public function __construct()
    {
        parent::__construct();
        $this->card_array = new Card();
    }

    public function get_deck(): array
    {
        return $this->card_array->get_cards();
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
