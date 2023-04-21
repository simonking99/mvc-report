<?php

namespace App\Card;

#Dice ärver från DeckOfCards
class Card extends DeckOfCards
{
    public function __construct()
    {
        parent::__construct();
    }

    public function draw_card(): string
    {
        //Får ett random element från arrayen
        $randomIndex = array_rand($this->value);
        $randomElement = $this->value[$randomIndex];

        //Tar bort random elemetet från arrayen
        unset($this->value[$randomIndex]);

        //Returnerar random elementet
        return $randomElement;
    }
}

