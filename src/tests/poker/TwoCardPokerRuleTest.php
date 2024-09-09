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

  public function testJudgeTheWinner()
  {
    $rule = new TwoCardPokerRule();
    $this->assertSame(0, $rule->judgeTheWinner([['name' => 'high card', 'primary' => 3, 'secondary' => 1, 'handRank' => 1], ['name' => 'high card', 'primary' => 3, 'secondary' => 1, 'handRank' => 1]]));
    $this->assertSame(1, $rule->judgeTheWinner([['name' => 'high card', 'primary' => 6, 'secondary' => 2, 'handRank' => 1], ['name' => 'high card', 'primary' => 4, 'secondary' => 1, 'handRank' => 1]]));
    $this->assertSame(1, $rule->judgeTheWinner([['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'handRank' => 1], ['name' => 'high card', 'primary' => 3, 'secondary' => 1, 'handRank' => 1]]));
    $this->assertSame(2, $rule->judgeTheWinner([['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'handRank' => 1], ['name' => 'pair', 'primary' => 1, 'secondary' => 1, 'handRank' => 2]]));
    $this->assertSame(2, $rule->judgeTheWinner([['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'handRank' => 1], ['name' => 'straight', 'primary' => 2, 'secondary' => 1, 'handRank' => 3]]));
    $this->assertSame(2, $rule->judgeTheWinner([['name' => 'pair', 'primary' => 3, 'secondary' => 3, 'handRank' => 2], ['name' => 'straight', 'primary' => 2, 'secondary' => 1, 'handRank' => 3]]));
    $this->assertSame(2, $rule->judgeTheWinner([['name' => 'straight', 'primary' => 4, 'secondary' => 3, 'handRank' => 3], ['name' => 'straight', 'primary' => 13, 'secondary' => 1, 'handRank' => 3]]));
  }
}
