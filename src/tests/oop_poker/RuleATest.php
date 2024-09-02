<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\RuleA;
use OopPoker\Card;

require_once(__DIR__ . '../../../lib/oop_poker/RuleA.php');

class RuleATest extends TestCase
{
  public function testGetHand()
  {
    $rule = new RuleA();
    $cards = [new Card('H', 10), new Card('C', 10)];
    $this->assertSame('pair', $rule->getHand($cards));
  }
}
