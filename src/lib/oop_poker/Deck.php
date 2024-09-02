<?php

namespace OopPoker;

require_once('Card.php');

class Deck
{

  private array $cards;
  public function __construct()
  {
    foreach (['H', 'S', 'D', 'C'] as $suit) {
      foreach (range(1, 13) as $number) {
        $this->cards[] = new Card($suit, $number);
      }
    }
    // カードをシャッフルする
  }

  public function drawCards(int $drawNum): array
  {
    return array_slice($this->cards, 0, $drawNum);
  }
}
