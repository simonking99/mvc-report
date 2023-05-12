<?php

namespace App\Card;

class DeckOfCardsJoker extends DeckOfCards
{
    public function __construct()
    {
        parent::__construct();
        $this->value = ['🃏', '🃏'];
    }

    public function add_joker(): array
    {
      $jokers = parent::get_deck(); // Get the cards array from the parent class

      for ($i = 0; $i < 2; $i++) {
          $jokers[] = $this->value[$i]; // Add the jokers to the cards array
      }

      return $jokers;
  }
}
