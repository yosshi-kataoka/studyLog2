<?php

namespace OopPoker;

class HandEvaluator
{
  public function __construct(private Rule $rule) {}

  public function getHand(array $cards): string
  {
    return $this->rule->getHand($cards);
  }

  public static function getWinner(string $hand1, string $hand2): int
  {
    return 1;
  }
}
