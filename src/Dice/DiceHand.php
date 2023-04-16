<?php

namespace App\Dice;

use App\Dice\Dice;

class DiceHand
{   
    #Skapar handen
    private $hand = [];

    #Lägger till tärningingar i Tärningshanden
    #Tärningshanden är beroende av tärningar
    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }

    #Alt 2
    #public function add(Dice $die): void
    #{
        #$this->hand[] = new Dice();
    #}

    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getValue();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getAsString();
        }
        return $values;
    }
}