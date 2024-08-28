<?php

namespace poker;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/poker/TwoCardPokerRule.php');

class TwoCardPokerRuleTest extends TestCase
{
  public function testGetHand()
  {
    $rule = new TwoCardPokerRule();
    $this->assertSame('high card', $rule->getHand([1, 3]));
    $this->assertSame('pair', $rule->getHand([1, 1]));
    $this->assertSame('straight', $rule->getHand([2, 1]));
    $this->assertSame('straight', $rule->getHand([13, 1]));
    $this->assertSame('straight', $rule->getHand([13, 12]));
  }
}