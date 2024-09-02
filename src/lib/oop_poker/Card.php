<?php

namespace OopPoker;

class Card
{
  public function __construct(private string $suit, private int $number) {}

  public function getSuit(): string
  {
    return $this->suit;
  }
  public function getNumber(): int
  {
    return $this->number;
  }
}
