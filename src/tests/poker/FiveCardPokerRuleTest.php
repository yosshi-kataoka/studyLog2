<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\FiveCardPokerRule;

require_once(__DIR__ . '../../../lib/poker/FiveCardPokerRule.php');

class FiveCardPokerRuleTest extends TestCase
{
  public function testGetHand()
  {
    $rule = new FiveCardPokerRule();
    $this->assertSame('high card', $rule->getHand([1, 12, 13, 2, 5]));
    $this->assertSame('high card', $rule->getHand([13, 12, 3, 2, 1]));
    $this->assertSame('high card', $rule->getHand([13, 11, 12, 2, 1]));
    $this->assertSame('high card', $rule->getHand([13, 10, 11, 12, 1]));
    $this->assertSame('one pair', $rule->getHand([1, 1, 3, 5, 6]));
    $this->assertSame('two pair', $rule->getHand([2, 2, 8, 8, 6]));
    $this->assertSame('straight', $rule->getHand([2, 1, 3, 5, 4]));
    $this->assertSame('straight', $rule->getHand([9, 10, 11, 12, 13]));
    $this->assertSame('straight', $rule->getHand([13, 4, 3, 2, 1]));
    $this->assertSame('three of a kind', $rule->getHand([1, 1, 1, 6, 9]));
    $this->assertSame('four of a kind', $rule->getHand([1, 1, 1, 1, 9]));
    $this->assertSame('full house', $rule->getHand([1, 1, 1, 9, 9]));
  }
}
