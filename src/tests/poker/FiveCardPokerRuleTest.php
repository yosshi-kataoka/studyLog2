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
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 5, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 1], $rule->getHand([1, 12, 13, 2, 5]));
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 3, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 1], $rule->getHand([13, 12, 3, 2, 1]));
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 1], $rule->getHand([13, 11, 12, 2, 1]));
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'quaternary' => 10, 'quinary' => 1, 'handRank' => 1], $rule->getHand([13, 10, 11, 12, 1]));
    $this->assertSame(['name' => 'one pair', 'primary' => 1, 'secondary' => 6, 'tertiary' => 5, 'quaternary' => 3, 'quinary' => 1, 'handRank' => 2], $rule->getHand([1, 1, 3, 5, 6]));
    $this->assertSame(['name' => 'one pair', 'primary' => 3, 'secondary' => 6, 'tertiary' => 5, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 2], $rule->getHand([1, 3, 3, 5, 6]));
    $this->assertSame(['name' => 'one pair', 'primary' => 5, 'secondary' => 6, 'tertiary' => 3, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 2], $rule->getHand([1, 3, 5, 5, 6]));
    $this->assertSame(['name' => 'one pair', 'primary' => 6, 'secondary' => 5, 'tertiary' => 3, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 2], $rule->getHand([1, 3, 5, 6, 6]));
    $this->assertSame(['name' => 'two pair', 'primary' => 8, 'secondary' => 2, 'tertiary' => 6, 'quaternary' => 2, 'quinary' => 2, 'handRank' => 3], $rule->getHand([2, 2, 8, 8, 6]));
    $this->assertSame(['name' => 'two pair', 'primary' => 8, 'secondary' => 6, 'tertiary' => 2, 'quaternary' => 6, 'quinary' => 2, 'handRank' => 3], $rule->getHand([6, 6, 8, 8, 2]));
    $this->assertSame(['name' => 'two pair', 'primary' => 8, 'secondary' => 6, 'tertiary' => 10, 'quaternary' => 6, 'quinary' => 6, 'handRank' => 3], $rule->getHand([6, 6, 8, 8, 10]));
    $this->assertSame(['name' => 'straight', 'primary' => 5, 'secondary' => 4, 'tertiary' => 3, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 4], $rule->getHand([2, 1, 3, 5, 4]));
    $this->assertSame(['name' => 'straight', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'quaternary' => 10, 'quinary' => 9, 'handRank' => 4], $rule->getHand([9, 10, 11, 12, 13]));
    $this->assertSame(['name' => 'straight', 'primary' => 4, 'secondary' => 13, 'tertiary' => 3, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 4], $rule->getHand([13, 4, 3, 2, 1]));
    $this->assertSame(['name' => 'three of a kind', 'primary' => 1, 'secondary' => 9, 'tertiary' => 6, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 5], $rule->getHand([1, 1, 1, 6, 9]));
    $this->assertSame(['name' => 'three of a kind', 'primary' => 6, 'secondary' => 9, 'tertiary' => 1, 'quaternary' => 6, 'quinary' => 1, 'handRank' => 5], $rule->getHand([1, 6, 6, 6, 9]));
    $this->assertSame(['name' => 'three of a kind', 'primary' => 9, 'secondary' => 6, 'tertiary' => 1, 'quaternary' => 6, 'quinary' => 1, 'handRank' => 5], $rule->getHand([1, 6, 9, 9, 9]));
    $this->assertSame(['name' => 'full house', 'primary' => 9, 'secondary' => 1, 'tertiary' => 1, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 6], $rule->getHand([1, 1, 1, 9, 9]));
    $this->assertSame(['name' => 'full house', 'primary' => 9, 'secondary' => 1, 'tertiary' => 9, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 6], $rule->getHand([1, 1, 9, 9, 9]));
    $this->assertSame(['name' => 'four of a kind', 'primary' => 1, 'secondary' => 6, 'tertiary' => 1, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 7], $rule->getHand([1, 1, 1, 1, 6]));
    $this->assertSame(['name' => 'four of a kind', 'primary' => 9, 'secondary' => 1, 'tertiary' => 9, 'quaternary' => 9, 'quinary' => 1, 'handRank' => 7], $rule->getHand([1, 9, 9, 9, 9]));
  }
  public function testJudgeTheWinner()
  {
    $rule = new FiveCardPokerRule();
    $this->assertSame(0, $rule->judgeTheWinner([$rule->getHand([1, 12, 13, 2, 5]), $rule->getHand([1, 12, 13, 2, 5])]));
    $this->assertSame(1, $rule->judgeTheWinner([$rule->getHand([1, 12, 13, 2, 5]), $rule->getHand([1, 11, 12, 2, 5])]));
    $this->assertSame(1, $rule->judgeTheWinner([$rule->getHand([1, 12, 13, 2, 5]), $rule->getHand([1, 11, 13, 2, 5])]));
    $this->assertSame(1, $rule->judgeTheWinner([$rule->getHand([1, 12, 13, 2, 5]), $rule->getHand([1, 12, 13, 2, 4])]));
    $this->assertSame(1, $rule->judgeTheWinner([$rule->getHand([1, 12, 13, 3, 5]), $rule->getHand([1, 12, 13, 2, 5])]));
    $this->assertSame(1, $rule->judgeTheWinner([$rule->getHand([2, 12, 13, 3, 5]), $rule->getHand([1, 12, 13, 3, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 12, 13, 3, 5]), $rule->getHand([1, 12, 13, 5, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 12, 13, 3, 5]), $rule->getHand([9, 9, 12, 5, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 12, 13, 3, 5]), $rule->getHand([9, 13, 12, 10, 11])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 12, 13, 3, 5]), $rule->getHand([9, 13, 13, 13, 11])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 12, 13, 3, 5]), $rule->getHand([9, 13, 13, 13, 9])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 12, 13, 3, 5]), $rule->getHand([13, 13, 13, 13, 9])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 12, 12, 3, 5]), $rule->getHand([9, 13, 13, 3, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 3, 5]), $rule->getHand([2, 13, 13, 5, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 3, 5]), $rule->getHand([9, 13, 12, 10, 11])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 3, 5]), $rule->getHand([9, 13, 13, 13, 11])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 3, 5]), $rule->getHand([9, 13, 13, 13, 9])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 3, 5]), $rule->getHand([12, 12, 12, 12, 9])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 5, 5]), $rule->getHand([2, 13, 13, 12, 12])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 5, 5]), $rule->getHand([1, 2, 3, 4, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 5, 5]), $rule->getHand([1, 3, 3, 3, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 5, 5]), $rule->getHand([5, 3, 3, 3, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 13, 13, 5, 5]), $rule->getHand([3, 3, 3, 3, 5])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 3, 4, 5, 1]), $rule->getHand([9, 10, 11, 12, 13])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 3, 4, 5, 1]), $rule->getHand([10, 10, 10, 12, 13])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 3, 4, 5, 1]), $rule->getHand([10, 10, 10, 12, 12])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([2, 3, 4, 5, 1]), $rule->getHand([10, 10, 10, 10, 12])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([3, 3, 3, 5, 1]), $rule->getHand([10, 10, 10, 8, 12])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([3, 3, 3, 5, 1]), $rule->getHand([10, 10, 10, 12, 12])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([3, 3, 3, 5, 1]), $rule->getHand([10, 10, 10, 10, 12])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([3, 3, 3, 5, 5]), $rule->getHand([10, 10, 10, 12, 12])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([3, 3, 3, 5, 5]), $rule->getHand([10, 10, 10, 10, 12])]));
    $this->assertSame(2, $rule->judgeTheWinner([$rule->getHand([3, 3, 3, 3, 5]), $rule->getHand([10, 10, 10, 10, 12])]));
  }
}
