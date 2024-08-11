<?php

namespace Calc;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../lib/Calc.php');

class CalcTest extends TestCase
{
  private $buyingTime = '12:00';
  private $purchaseQuantity = [1, 1, 1, 3, 5, 7, 2, 4, 9];

  public function testCalcPrice()
  {
    $result = calcPrice($this->purchaseQuantity, $this->buyingTime);
    $this->assertSame(1793, $result);
  }

  public function testDisplay()
  {
    $result = calcPrice($this->purchaseQuantity, $this->buyingTime);
    $output = <<< EOD
    合計金額:1793円です。

    EOD;
    $this->expectOutputString($output);
    display($result);
  }

  public function testCalc()
  {
    $output = <<< EOD
    合計金額:1474円です。

    EOD;
    $this->expectOutputString($output);
    calc('21:00', [1, 1, 1, 1, 1, 2, 2, 2, 7, 8, 10]);
  }
}
