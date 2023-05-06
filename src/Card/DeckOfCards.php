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
        return $this->value;
    }

    public function shuffle_deck(): array
    {
        shuffle($this->value);
        return $this->value;
    }
}

