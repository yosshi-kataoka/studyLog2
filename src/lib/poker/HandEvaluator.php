<?php

namespace Poker;

require_once('Rule.php');

class HandEvaluator
{
  public function __construct(private Rule $rule) {}

  public function getHand(array $card): array
  {
    return $this->rule->getHand($card);
  }

  public function judgeTheWinner(array $card): int
  {
    return $this->rule->judgeTheWinner($card);
  }
}
