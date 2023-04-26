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
