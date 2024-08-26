<?php

namespace poker;

class Card
{
  public const CARD_RANKS = [
    '2' => 1,
    '3' => 2,
    '4' => 3,
    '5' => 4,
    '6' => 5,
    '7' => 6,
    '8' => 7,
    '9' => 8,
    '10' => 9,
    'J' => 10,
    'Q' => 11,
    'K' => 12,
    'A' => 13
  ];

  private $suit;
  private $number = [];

  public function __construct(private array $cards)
  {
    $this->suit = array_map(fn($card) => mb_substr($card, 0, 1), $this->cards);
    $numbers = array_map(fn($card) => mb_substr($card, 1, strlen($card) - 1), $this->cards);
    foreach ($numbers as $number) {
      $this->number[] = self::CARD_RANKS[$number];
    }
  }

  public function getNumber(): array
  {
    return $this->number;
  }
  public function getSuit(): array
  {
    return $this->suit;
  }
}
