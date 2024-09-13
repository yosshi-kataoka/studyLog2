<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\HandEvaluator;
use Poker\TwoCardPokerRule;
use Poker\ThreeCardPokerRule;
use Poker\FiveCardPokerRule;

require_once(__DIR__ . '../../../lib/poker/HandEvaluator.php');
require_once(__DIR__ . '../../../lib/poker/Rule.php');

class HandEvaluatorTest extends TestCase
{
  public function testGetHand()
  {
    // カードが2枚の場合
    $rule = new TwoCardPokerRule();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame(['name' => 'high card', 'primary' => 3, 'secondary' => 1, 'handRank' => 1], $handEvaluator->getHand([1, 3]));
    $this->assertSame(['name' => 'pair', 'primary' => 1, 'secondary' => 1, 'handRank' => 2], $handEvaluator->getHand([1, 1]));
    $this->assertSame(['name' => 'straight', 'primary' => 2, 'secondary' => 1, 'handRank' => 3], $handEvaluator->getHand([2, 1]));
    $this->assertSame(['name' => 'straight', 'primary' => 13, 'secondary' => 1, 'handRank' => 3], $handEvaluator->getHand([13, 1]));
    $this->assertSame(['name' => 'straight', 'primary' => 13, 'secondary' => 12, 'handRank' => 3], $handEvaluator->getHand([13, 12]));
    // カードが3枚の場合
    $rule = new ThreeCardPokerRule();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 1, 'handRank' => 1], $handEvaluator->getHand([1, 12, 13]));
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 4, 'tertiary' => 1, 'handRank' => 1], $handEvaluator->getHand([1, 4, 13]));
    $this->assertSame(['name' => 'pair', 'primary' => 1, 'secondary' => 1, 'tertiary' => 3, 'handRank' => 2], $handEvaluator->getHand([1, 1, 3]));
    $this->assertSame(['name' => 'straight', 'primary' => 3, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 3], $handEvaluator->getHand([2, 1, 3]));
    $this->assertSame(['name' => 'straight', 'primary' => 2, 'secondary' => 13, 'tertiary' => 1, 'handRank' => 3], $handEvaluator->getHand([13, 1, 2]));
    $this->assertSame(['name' => 'straight', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'handRank' => 3], $handEvaluator->getHand([13, 12, 11]));
    $this->assertSame(['name' => 'three card', 'primary' => 1, 'secondary' => 1, 'tertiary' => 1, 'handRank' => 4], $handEvaluator->getHand([1, 1, 1]));

    //カードが5枚の場合
    $rule = new FiveCardPokerRule();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 5, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 1], $handEvaluator->getHand([1, 12, 13, 2, 5]));
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 3, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 1], $handEvaluator->getHand([13, 12, 3, 2, 1]));
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 1], $handEvaluator->getHand([13, 11, 12, 2, 1]));
    $this->assertSame(['name' => 'high card', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'quaternary' => 10, 'quinary' => 1, 'handRank' => 1], $handEvaluator->getHand([13, 10, 11, 12, 1]));
    $this->assertSame(['name' => 'one pair', 'primary' => 1, 'secondary' => 6, 'tertiary' => 5, 'quaternary' => 3, 'quinary' => 1, 'handRank' => 2], $handEvaluator->getHand([1, 1, 3, 5, 6]));
    $this->assertSame(['name' => 'one pair', 'primary' => 3, 'secondary' => 6, 'tertiary' => 5, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 2], $handEvaluator->getHand([1, 3, 3, 5, 6]));
    $this->assertSame(['name' => 'one pair', 'primary' => 5, 'secondary' => 6, 'tertiary' => 3, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 2], $handEvaluator->getHand([1, 3, 5, 5, 6]));
    $this->assertSame(['name' => 'one pair', 'primary' => 6, 'secondary' => 5, 'tertiary' => 3, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 2], $handEvaluator->getHand([1, 3, 5, 6, 6]));
    $this->assertSame(['name' => 'two pair', 'primary' => 8, 'secondary' => 2, 'tertiary' => 6, 'quaternary' => 2, 'quinary' => 2, 'handRank' => 3], $handEvaluator->getHand([2, 2, 8, 8, 6]));
    $this->assertSame(['name' => 'two pair', 'primary' => 8, 'secondary' => 6, 'tertiary' => 2, 'quaternary' => 6, 'quinary' => 2, 'handRank' => 3], $handEvaluator->getHand([6, 6, 8, 8, 2]));
    $this->assertSame(['name' => 'two pair', 'primary' => 8, 'secondary' => 6, 'tertiary' => 10, 'quaternary' => 6, 'quinary' => 6, 'handRank' => 3], $handEvaluator->getHand([6, 6, 8, 8, 10]));
    $this->assertSame(['name' => 'straight', 'primary' => 5, 'secondary' => 4, 'tertiary' => 3, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 4], $handEvaluator->getHand([2, 1, 3, 5, 4]));
    $this->assertSame(['name' => 'straight', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'quaternary' => 10, 'quinary' => 9, 'handRank' => 4], $handEvaluator->getHand([9, 10, 11, 12, 13]));
    $this->assertSame(['name' => 'straight', 'primary' => 4, 'secondary' => 13, 'tertiary' => 3, 'quaternary' => 2, 'quinary' => 1, 'handRank' => 4], $handEvaluator->getHand([13, 4, 3, 2, 1]));
    $this->assertSame(['name' => 'three of a kind', 'primary' => 1, 'secondary' => 9, 'tertiary' => 6, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 5], $handEvaluator->getHand([1, 1, 1, 6, 9]));
    $this->assertSame(['name' => 'three of a kind', 'primary' => 6, 'secondary' => 9, 'tertiary' => 1, 'quaternary' => 6, 'quinary' => 1, 'handRank' => 5], $handEvaluator->getHand([1, 6, 6, 6, 9]));
    $this->assertSame(['name' => 'three of a kind', 'primary' => 9, 'secondary' => 6, 'tertiary' => 1, 'quaternary' => 6, 'quinary' => 1, 'handRank' => 5], $handEvaluator->getHand([1, 6, 9, 9, 9]));
    $this->assertSame(['name' => 'full house', 'primary' => 9, 'secondary' => 1, 'tertiary' => 1, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 6], $handEvaluator->getHand([1, 1, 1, 9, 9]));
    $this->assertSame(['name' => 'full house', 'primary' => 9, 'secondary' => 1, 'tertiary' => 9, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 6], $handEvaluator->getHand([1, 1, 9, 9, 9]));
    $this->assertSame(['name' => 'four of a kind', 'primary' => 1, 'secondary' => 6, 'tertiary' => 1, 'quaternary' => 1, 'quinary' => 1, 'handRank' => 7], $handEvaluator->getHand([1, 1, 1, 1, 6]));
    $this->assertSame(['name' => 'four of a kind', 'primary' => 9, 'secondary' => 1, 'tertiary' => 9, 'quaternary' => 9, 'quinary' => 1, 'handRank' => 7], $handEvaluator->getHand([1, 9, 9, 9, 9]));
  }

  public function testJudgeTheWinner()
  {
    // カードが2枚の場合
    $rule = new TwoCardPokerRule();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame(0, $handEvaluator->judgeTheWinner([['name' => 'high card', 'primary' => 3, 'secondary' => 1, 'handRank' => 1], ['name' => 'high card', 'primary' => 3, 'secondary' => 1, 'handRank' => 1]]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([['name' => 'high card', 'primary' => 6, 'secondary' => 2, 'handRank' => 1], ['name' => 'high card', 'primary' => 4, 'secondary' => 1, 'handRank' => 1]]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'handRank' => 1], ['name' => 'high card', 'primary' => 3, 'secondary' => 1, 'handRank' => 1]]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'handRank' => 1], ['name' => 'pair', 'primary' => 1, 'secondary' => 1, 'handRank' => 2]]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'handRank' => 1], ['name' => 'straight', 'primary' => 2, 'secondary' => 1, 'handRank' => 3]]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([['name' => 'pair', 'primary' => 3, 'secondary' => 3, 'handRank' => 2], ['name' => 'straight', 'primary' => 2, 'secondary' => 1, 'handRank' => 3]]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([['name' => 'straight', 'primary' => 4, 'secondary' => 3, 'handRank' => 3], ['name' => 'straight', 'primary' => 13, 'secondary' => 1, 'handRank' => 3]]));

    // カードが3枚の場合
    $rule = new ThreeCardPokerRule();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame(0, $handEvaluator->judgeTheWinner([['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1], ['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1]]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1],
      ['name' => 'high card', 'primary' => 4, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1]
    ]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 1, 'handRank' => 1],
      ['name' => 'high card', 'primary' => 5, 'secondary' => 2, 'tertiary' => 1, 'handRank' => 1]
    ]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 2, 'handRank' => 1],
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 1, 'handRank' => 1]
    ]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 2, 'handRank' => 1],
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 1, 'handRank' => 2]
    ]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 2, 'handRank' => 1],
      ['name' => 'straight', 'primary' => 1, 'secondary' => 2, 'tertiary' => 3, 'handRank' => 3]
    ]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([
      ['name' => 'high card', 'primary' => 5, 'secondary' => 3, 'tertiary' => 2, 'handRank' => 1],
      ['name' => 'three card', 'primary' => 1, 'secondary' => 1, 'tertiary' => 1, 'handRank' => 4]
    ]));
    $this->assertSame(0, $handEvaluator->judgeTheWinner([
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 2, 'handRank' => 2],
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 2, 'handRank' => 2]
    ]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 3, 'handRank' => 2],
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 2, 'handRank' => 2]
    ]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 3, 'handRank' => 2],
      ['name' => 'straight', 'primary' => 1, 'secondary' => 2, 'tertiary' => 3, 'handRank' => 3]
    ]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([
      ['name' => 'pair', 'primary' => 5, 'secondary' => 5, 'tertiary' => 3, 'handRank' => 2],
      ['name' => 'three card', 'primary' => 1, 'secondary' => 1, 'tertiary' => 1, 'handRank' => 4]
    ]));
    $this->assertSame(0, $handEvaluator->judgeTheWinner([
      ['name' => 'straight', 'primary' => 1, 'secondary' => 2, 'tertiary' => 3, 'handRank' => 3],
      ['name' => 'straight', 'primary' => 1, 'secondary' => 2, 'tertiary' => 3, 'handRank' => 3]
    ]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([
      ['name' => 'straight', 'primary' => 3, 'secondary' => 13, 'tertiary' => 1, 'handRank' => 3],
      ['name' => 'straight', 'primary' => 13, 'secondary' => 12, 'tertiary' => 11, 'handRank' => 3]
    ]));
    $this->assertSame(0, $handEvaluator->judgeTheWinner([
      ['name' => 'three card', 'primary' => 3, 'secondary' => 3, 'tertiary' => 3, 'handRank' => 4],
      ['name' => 'three card', 'primary' => 3, 'secondary' => 3, 'tertiary' => 3, 'handRank' => 4]
    ]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([
      ['name' => 'three card', 'primary' => 1, 'secondary' => 1, 'tertiary' => 1, 'handRank' => 4],
      ['name' => 'three card', 'primary' => 13, 'secondary' => 13, 'tertiary' => 13, 'handRank' => 4]
    ]));

    // カードが5枚の場合
    $rule = new FiveCardPokerRule();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame(0, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([1, 12, 13, 2, 5]), $handEvaluator->getHand([1, 12, 13, 2, 5])]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([1, 12, 13, 2, 5]), $handEvaluator->getHand([1, 11, 12, 2, 5])]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([1, 12, 13, 2, 5]), $handEvaluator->getHand([1, 11, 13, 2, 5])]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([1, 12, 13, 2, 5]), $handEvaluator->getHand([1, 12, 13, 2, 4])]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([1, 12, 13, 3, 5]), $handEvaluator->getHand([1, 12, 13, 2, 5])]));
    $this->assertSame(1, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 12, 13, 3, 5]), $handEvaluator->getHand([1, 12, 13, 3, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 12, 13, 3, 5]), $handEvaluator->getHand([1, 12, 13, 5, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 12, 13, 3, 5]), $handEvaluator->getHand([9, 9, 12, 5, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 12, 13, 3, 5]), $handEvaluator->getHand([9, 13, 12, 10, 11])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 12, 13, 3, 5]), $handEvaluator->getHand([9, 13, 13, 13, 11])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 12, 13, 3, 5]), $handEvaluator->getHand([9, 13, 13, 13, 9])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 12, 13, 3, 5]), $handEvaluator->getHand([13, 13, 13, 13, 9])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 12, 12, 3, 5]), $handEvaluator->getHand([9, 13, 13, 3, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 3, 5]), $handEvaluator->getHand([2, 13, 13, 5, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 3, 5]), $handEvaluator->getHand([9, 13, 12, 10, 11])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 3, 5]), $handEvaluator->getHand([9, 13, 13, 13, 11])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 3, 5]), $handEvaluator->getHand([9, 13, 13, 13, 9])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 3, 5]), $handEvaluator->getHand([12, 12, 12, 12, 9])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 5, 5]), $handEvaluator->getHand([2, 13, 13, 12, 12])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 5, 5]), $handEvaluator->getHand([1, 2, 3, 4, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 5, 5]), $handEvaluator->getHand([1, 3, 3, 3, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 5, 5]), $handEvaluator->getHand([5, 3, 3, 3, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 13, 13, 5, 5]), $handEvaluator->getHand([3, 3, 3, 3, 5])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 3, 4, 5, 1]), $handEvaluator->getHand([9, 10, 11, 12, 13])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 3, 4, 5, 1]), $handEvaluator->getHand([10, 10, 10, 12, 13])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 3, 4, 5, 1]), $handEvaluator->getHand([10, 10, 10, 12, 12])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([2, 3, 4, 5, 1]), $handEvaluator->getHand([10, 10, 10, 10, 12])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([3, 3, 3, 5, 1]), $handEvaluator->getHand([10, 10, 10, 8, 12])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([3, 3, 3, 5, 1]), $handEvaluator->getHand([10, 10, 10, 12, 12])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([3, 3, 3, 5, 1]), $handEvaluator->getHand([10, 10, 10, 10, 12])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([3, 3, 3, 5, 5]), $handEvaluator->getHand([10, 10, 10, 12, 12])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([3, 3, 3, 5, 5]), $handEvaluator->getHand([10, 10, 10, 10, 12])]));
    $this->assertSame(2, $handEvaluator->judgeTheWinner([$handEvaluator->getHand([3, 3, 3, 3, 5]), $handEvaluator->getHand([10, 10, 10, 10, 12])]));
  }
}
