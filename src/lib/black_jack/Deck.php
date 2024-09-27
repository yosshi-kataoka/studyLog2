<?php

namespace BlackJack;

class Deck
{
  private array $cards;
  public function __construct()
  {
    foreach (['H', 'S', 'D', 'C'] as $suit) {
      foreach (['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K'] as $number) {
        $this->cards[] = [$suit, $number];
      }
    }
    shuffle($this->cards);
  }

  public function drawCard() {}
}
