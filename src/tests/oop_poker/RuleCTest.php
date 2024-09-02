<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\RuleC;
use OopPoker\Card;

require_once(__DIR__ . '../../../lib/oop_poker/RuleC.php');

class RuleCTest extends TestCase
{
  public function testGetHand()
  {
    $rule = new RuleC();
    $cards = [new Card('H', 10), new Card('C', 10)];
    $this->assertSame('straight', $rule->getHand($cards));
  }
}
