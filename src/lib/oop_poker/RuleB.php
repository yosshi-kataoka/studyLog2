<?php

namespace OopPoker;

require_once('Rule.php');

class RuleB implements Rule
{
  public function getHand(array $cards): string
  {
    return 'high card';
  }
}
