<?php

namespace App\Card;

class DeckOfCards
{
    protected $value = [
        '🃁',
        '🃂',
        '🃃',
        '🃄',
        '🃅',
        '🃆',
        '🃇',
        '🃈',
        '🃉',
        '🃊',
        '🃋',
        '🃌',
        '🃍',
        '🃎',
        '🃏'
    ];

    public function getAsString(): string
    {
        return implode(" ", $this->value);
    }
}