<?php

namespace poker;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/poker/ThreeCardPokerRule.php');

class ThreeCardPokerRuleTest extends TestCase
{
  public function testGetHand()
  {
    $rule = new ThreeCardPokerRule();
    $this->assertSame('high card', $rule->getHand([1, 12, 13]));
    $this->assertSame('high card', $rule->getHand([1, 12, 13]));
    $this->assertSame('pair', $rule->getHand([1, 1, 3]));
    $this->assertSame('straight', $rule->getHand([2, 1, 3]));
    $this->assertSame('straight', $rule->getHand([13, 1, 2]));
    $this->assertSame('straight', $rule->getHand([13, 12, 11]));
    $this->assertSame('three of a kind', $rule->getHand([1, 1, 1]));
  }
}
