<?php

class PokerGame
{
  public function __construct(private array $cards) {}

  public function start(): array
  {
    return $this->cards;
  }
}
