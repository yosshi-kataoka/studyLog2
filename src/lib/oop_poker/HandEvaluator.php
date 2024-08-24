<?php

class HandEvaluator
{
  public function __construct(private $rule) {}

  public function getHand(array $cards): string
  {
    return $this->rule->getHand($cards);
  }
}
