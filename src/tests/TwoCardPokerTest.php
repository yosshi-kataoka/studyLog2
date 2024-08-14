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
    $this->assertSame(['name' => 'high card', 'strengthHand' => 1, 'primary' => 9, 'secondary' => 6], judgeTheHand(6, 9));
    $this->assertSame(['name' => 'pair', 'strengthHand' => 2, 'primary' => 8, 'secondary' => 8], judgeTheHand(8, 8));
    $this->assertSame(['name' => 'straight', 'strengthHand' => 3, 'primary' => 13, 'secondary' => 12], judgeTheHand(13, 12));
    $this->assertSame(['name' => 'straight', 'strengthHand' => 3, 'primary' => 1, 'secondary' => 13], judgeTheHand(13, 1));
  }

  public function testShowDown()
  {
    showDown('CK', 'DJ', 'C10', 'H10'); //=> ['high card', 'pair', 2]
    showDown('CK', 'DJ', 'C3', 'H4');  //=> ['high card', 'straight', 2]
    showDown('C3', 'H4', 'DK', 'SK');  //=> ['straight', 'pair', 1]
    showDown('HJ', 'SK', 'DQ', 'D10'); //=> ['high card', 'high card', 1]
    showDown('H9', 'SK', 'DK', 'D10'); //=> ['high card', 'high card', 2]
    showDown('H3', 'S5', 'D5', 'D3'); //=> ['high card', 'high card', 0]
    showDown('CA', 'DA', 'C2', 'D2'); //=> ['pair', 'pair', 1]
    showDown('CK', 'DK', 'CA', 'DA'); //=> ['pair', 'pair', 2]
    showDown('C4', 'D4', 'H4', 'S4'); //=> ['pair', 'pair', 0]
    showDown('SA', 'DK', 'C2', 'CA'); //=> ['straight', 'straight', 1]
    showDown('C2', 'CA', 'S2', 'D3'); //=> ['straight', 'straight', 2]
    showDown('S2', 'D3', 'C2', 'H3'); //=> ['straight', 'straight', 0]
  }
}
