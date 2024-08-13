<?php

namespace TwoCardPoker;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../lib/TwoCardPoker.php');

class TwoCardPokerTest extends TestCase
{

  public function testConvertToStrength()
  {
    $cards = ['CK', 'DJ', 'C10', 'H10'];
    $playerCards = [];
    foreach ($cards as $card) {
      $playerCards[] = substr($card, 1);
    }
    $this->assertSame([12, 10, 9, 9], convertToStrength($playerCards));
  }

  public function testIsStraight()
  {
    $this->assertSame(true, isStraight(1));
    $this->assertSame(true, isStraight(12));
    $this->assertSame(false, isStraight(0));
    $this->assertSame(false, isStraight(6));
  }

  public function testIsPair()
  {
    $this->assertSame(true, isPair(0));
    $this->assertSame(false, isPair(1));
    $this->assertSame(false, isPair(12));
    $this->assertSame(false, isPair(6));
  }

  public function testJudgeTheHand()
  {
    $this->assertSame(['high card', 9], judgeTheHand([6, 9]));
    $this->assertSame(['pair', 8], judgeTheHand([8, 8]));
    $this->assertSame(['straight', 13], judgeTheHand([13, 12]));
    $this->assertSame(['straight', 1], judgeTheHand([13, 1]));
  }

  public function testDecideTheWinner()
  {
    $this->assertSame(1, decideTheWinner([['high card', 9], ['high card', 5]]));
    $this->assertSame(2, decideTheWinner([['high card', 5], ['high card', 9]]));
    $this->assertSame(0, decideTheWinner([['high card', 5], ['high card', 5]]));
    $this->assertSame(2, decideTheWinner([['high card', 5], ['pair', 5]]));
    $this->assertSame(2, decideTheWinner([['high card', 5], ['straight', 6]]));
    $this->assertSame(1, decideTheWinner([['pair', 6], ['pair', 5]]));
    $this->assertSame(2, decideTheWinner([['pair', 5], ['pair', 6]]));
    $this->assertSame(2, decideTheWinner([['pair', 5], ['straight', 6]]));
    $this->assertSame(2, decideTheWinner([['straight', 5], ['straight', 6]]));
    $this->assertSame(2, decideTheWinner([['straight', 1], ['straight', 13]]));
  }

  public function testDisplay()
  {
    $output = <<<EOD
    high card,high card,1

    EOD;
    $this->expectOutputString($output);
    display([['high card', 9], ['high card', 5]], 1);
  }

  public function testShowDown()
  {
    $this->assertSame('high card,pair,2', showDown('CK', 'DJ', 'C10', 'H10'));
  }
}
