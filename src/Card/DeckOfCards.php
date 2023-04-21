<?php

namespace App\Card;

class DeckOfCards
{
    public function __construct()
    {
        $this->value = [
            '🃁','🃂','🃃','🃄','🃅','🃆','🃇','🃈','🃉','🃊','🃋','🃎','🃍',
            '🃑','🃒','🃓','🃔','🃕','🃖','🃗','🃘','🃙','🃚','🃛','🃞','🃝',
            '🂱','🂲','🂳','🂴','🂵','🂶','🂷','🂸','🂹','🂺','🂻','🂾','🂽',
            '🂡','🂢','🂣','🂤','🂥','🂦','🂧','🂨','🂩','🂪','🂫','🂮','🂭',
        ];
    }

    public function get_deck(): array
    {
        //Returnerar kortleken
        return $this->value;
    }

    public function shuffle_deck(): array
    {
        //Blandar kortleken
        shuffle($this->value);
        return $this->value;
    }

    public function count_deck(): int
    {
        //Räknar antalet kort i kortleken
        return count($this->value);
    }
}

