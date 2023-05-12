<?php

namespace App\Card;

class DeckOfCards
{

    private $card_array;

    public function __construct()
    {
        $this->card_array = new Card();
    }

    #method that returns all card in deck
    public function get_deck(): array
    {
        return $this->card_array->get_cards();
    }

    #method that shuffles the deck
    public function shuffle_deck(): array
    {
        $cards = $this->get_deck();
        shuffle($cards);
        return $cards;
    }

    #method that count the amount of cards in deck
    public function count(): int
    {
        return count($this->get_deck());
    }

    #method that draws card from deck
    public function draw_card(): string
    {
        $deck = $this->get_deck();
        if (count($deck) === 0) {
            return "";
      }
        $randomIndex = array_rand($deck);
        $randomElement = $deck[$randomIndex];

        unset($deck[$randomIndex]);

        $this->card_array->value = array_values($deck);

        return $randomElement;
    }
}
