<?php

namespace poker;

require_once('Rule.php');

class HandEvaluator
{
  public function __construct(private Rule $rule) {}

  public function getHand(array $card): string
  {
    return $this->rule->getHand($card);
  }
}
