<?php

class HandEvaluator
{
  public function __construct(private Rule $rule) {}

  public function getHand(array $cards): string
  {
    return $this->rule->getHand($cards);
  }
}
