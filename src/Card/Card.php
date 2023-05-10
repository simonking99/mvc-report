<?php

namespace App\Card;

class Card
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

    public function get_cards(): array
    {
        return $this->value;
    }

    public function draw_card(): string
    {
        if (count($this->value) === 0) {
            return "";
        }

        //Får ett random element från arrayen
        $randomIndex = array_rand($this->value);
        $randomElement = $this->value[$randomIndex];

        //Tar bort random elemetet från arrayen
        unset($this->value[$randomIndex]);

        //Returnerar random elementet
        return $randomElement;
    }
}
