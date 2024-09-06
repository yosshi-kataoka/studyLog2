<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\TwoCardPokerRule;

require_once(__DIR__ . '../../../lib/poker/TwoCardPokerRule.php');

class TwoCardPokerRuleTest extends TestCase
{
  public function testGetHand()
  {
    $rule = new TwoCardPokerRule();
    $this->assertSame(['name' => 'high card', 'primary' => 3, 'secondary' => 1, 'handRank' => 1], $rule->getHand([1, 3]));
    $this->assertSame(['name' => 'pair', 'primary' => 1, 'secondary' => 1, 'handRank' => 2], $rule->getHand([1, 1]));
    $this->assertSame(['name' => 'straight', 'primary' => 2, 'secondary' => 1, 'handRank' => 3], $rule->getHand([2, 1]));
    $this->assertSame(['name' => 'straight', 'primary' => 13, 'secondary' => 1, 'handRank' => 3], $rule->getHand([13, 1]));
    $this->assertSame(['name' => 'straight', 'primary' => 13, 'secondary' => 12, 'handRank' => 3], $rule->getHand([13, 12]));
  }
}