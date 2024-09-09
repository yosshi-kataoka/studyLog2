<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\ThreeCardPokerRule;

require_once(__DIR__ . '../../../lib/poker/ThreeCardPokerRule.php');

class ThreeCardPokerRuleTest extends TestCase
{
  public function testGetHand()
  {
    $rule = new ThreeCardPokerRule();
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 1, 'handRank' => 1], $rule->getHand([1, 12, 13]));
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 4, 'tertiary' => 1, 'handRank' => 1], $rule->getHand([1, 4, 13]));
    $this->assertSame(['name' => 'pair', 'primary' => 1, 'secondary' => 1, 'tertiary' => 3, 'handRank' => 2], $rule->getHand([1, 1, 3]));
    $this->assertSame(['name' => 'straight', 'primary' => 3, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 3], $rule->getHand([2, 1, 3]));
    $this->assertSame(['name' => 'straight', 'primary' => 2, 'secondary' => 13, 'tertiary' => 1, 'handRank' => 3], $rule->getHand([13, 1, 2]));
    $this->assertSame(['name' => 'straight', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'handRank' => 3], $rule->getHand([13, 12, 11]));
    $this->assertSame(['name' => 'three card', 'primary' => 1, 'secondary' => 1, 'tertiary' => 1, 'handRank' => 4], $rule->getHand([1, 1, 1]));
  }

  public function testJudgeWinner()
  {
    $rule = new ThreeCardPokerRule();
    $this->assertSame(0, $rule->judgeTheWinner([['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1], ['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1]]));
    $this->assertSame(1, $rule->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1],
      ['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1]
    ]));
    $this->assertSame(1, $rule->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 1, 'handRank' => 1],
      ['name' => 'high card', 'primary' => 5, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1]
    ]));
    $this->assertSame(1, $rule->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 2, 'handRank' => 1],
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 1, 'handRank' => 1]
    ]));
    $this->assertSame(2, $rule->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 2, 'handRank' => 1],
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 1, 'handRank' => 2]
    ]));
    $this->assertSame(2, $rule->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 2, 'handRank' => 1],
      ['name' => 'straight', 'primary' => 1, 'secondary' => 2, 'tertiary' => 3, 'handRank' => 3]
    ]));
    $this->assertSame(2, $rule->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 2, 'handRank' => 1],
      ['name' => 'three card', 'primary' => 1, 'secondary' => 1, 'tertiary' => 1, 'handRank' => 4]
    ]));
    $this->assertSame(0, $rule->judgeTheWinner([
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 2, 'handRank' => 2],
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 2, 'handRank' => 2]
    ]));
    $this->assertSame(1, $rule->judgeTheWinner([
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 3, 'handRank' => 2],
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 2, 'handRank' => 2]
    ]));
    $this->assertSame(2, $rule->judgeTheWinner([
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 3, 'handRank' => 2],
      ['name' => 'straight', 'primary' => 1, 'secondary' => 2, 'tertiary' => 3, 'handRank' => 3]
    ]));
    $this->assertSame(2, $rule->judgeTheWinner([
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 3, 'handRank' => 2],
      ['name' => 'three card', 'primary' => 1, 'secondary' => 1, 'tertiary' => 1, 'handRank' => 4]
    ]));
    $this->assertSame(0, $rule->judgeTheWinner([
      ['name' => 'straight', 'primary' => 1, 'secondary' => 2, 'tertiary' => 3, 'handRank' => 3],
      ['name' => 'straight', 'primary' => 1, 'secondary' => 2, 'tertiary' => 3, 'handRank' => 3]
    ]));
    $this->assertSame(2, $rule->judgeTheWinner([
      ['name' => 'straight', 'primary' => 3, 'secondary' => 13, 'tertiary' => 1, 'handRank' => 3],
      ['name' => 'straight', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'handRank' => 3]
    ]));
    $this->assertSame(0, $rule->judgeTheWinner([
      ['name' => 'three card', 'primary' => 3, 'secondary' => 3, 'tertiary' => 3, 'handRank' => 4],
      ['name' => 'three card', 'primary' => 3, 'secondary' => 3, 'tertiary' => 3, 'handRank' => 4]
    ]));
    $this->assertSame(2, $rule->judgeTheWinner([
      ['name' => 'three card', 'primary' => 1, 'secondary' => 1, 'tertiary' => 1, 'handRank' => 4],
      ['name' => 'three card', 'primary' => 13, 'secondary' => 13, 'tertiary' => 13, 'handRank' => 4]
    ]));
  }
}
