<?php

require_once('Rule.php');

class RuleC implements Rule
{
  public function getHand(array $cards): string
  {
    return 'straight';
  }
}
