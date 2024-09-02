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
    $this->assertSame('high card', $handEvaluator->getHand([1, 3]));
    $this->assertSame('pair', $handEvaluator->getHand([1, 1]));
    $this->assertSame('straight', $handEvaluator->getHand([2, 1]));
    $this->assertSame('straight', $handEvaluator->getHand([13, 1]));
    $this->assertSame('straight', $handEvaluator->getHand([13, 12]));
    // カードが3枚の場合
    $rule = new ThreeCardPokerRule();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame('high card', $handEvaluator->getHand([1, 12, 13]));
    $this->assertSame('pair', $handEvaluator->getHand([1, 1, 3]));
    $this->assertSame('straight', $handEvaluator->getHand([2, 1, 3]));
    $this->assertSame('straight', $handEvaluator->getHand([13, 1, 2]));
    $this->assertSame('straight', $handEvaluator->getHand([13, 12, 11]));
    $this->assertSame('three card', $handEvaluator->getHand([1, 1, 1]));

    //カードが5枚の場合
    $rule = new FiveCardPokerRule();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame('high card', $handEvaluator->getHand([1, 12, 13, 2, 5]));
    $this->assertSame('high card', $handEvaluator->getHand([13, 12, 3, 2, 1]));
    $this->assertSame('high card', $handEvaluator->getHand([13, 11, 12, 2, 1]));
    $this->assertSame('high card', $handEvaluator->getHand([13, 10, 11, 12, 1]));
    $this->assertSame('one pair', $handEvaluator->getHand([1, 1, 3, 5, 6]));
    $this->assertSame('two pair', $handEvaluator->getHand([2, 2, 8, 8, 6]));
    $this->assertSame('straight', $handEvaluator->getHand([2, 1, 3, 5, 4]));
    $this->assertSame('straight', $handEvaluator->getHand([9, 10, 11, 12, 13]));
    $this->assertSame('straight', $handEvaluator->getHand([13, 4, 3, 2, 1]));
    $this->assertSame('three of a kind', $handEvaluator->getHand([1, 1, 1, 6, 9]));
    $this->assertSame('four of a kind', $handEvaluator->getHand([1, 1, 1, 1, 9]));
    $this->assertSame('full house', $handEvaluator->getHand([1, 1, 1, 9, 9]));
  }
}
