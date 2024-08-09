<?php

namespace Calc;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../lib/Calc.php');

class CalcTest extends TestCase
{
  private $buyingTime = '12:00';
  private $purchaseQuantity = [1, 1, 1, 3, 5, 7, 2, 4, 9];


  public function testSumBuyingPurchase()
  {
    $result = sumBuyingPurchase($this->purchaseQuantity);
    $this->assertSame(9, $result);
  }

  public function testConvertToPurchaseQuantity()
  {
    $result = convertToPurchaseQuantity($this->purchaseQuantity);
    $this->assertSame([1 => 3, 3 => 1, 5 => 1, 7 => 1, 2 => 1, 4 => 1, 9 => 1], $result);
  }

  public function testCalcDiscountPrice()
  {
    $this->assertSame(70, calcDiscountPrice('12:00', [1 => 3, 2 => 3, 7 => 1, 10 => 1]));
    $this->assertSame(120, calcDiscountPrice('12:00', [1 => 5, 2 => 3, 7 => 1, 10 => 1]));
    $this->assertSame(120, calcDiscountPrice('12:00', [1 => 5, 2 => 3, 7 => 2, 10 => 1]));
    $this->assertSame(120, calcDiscountPrice('12:00', [1 => 5, 2 => 3, 7 => 1, 8 => 2, 10 => 1]));
    $this->assertSame(340, calcDiscountPrice('21:00', [1 => 5, 2 => 3, 7 => 1, 10 => 1]));
  }

  public function testCalcPrice()
  {
    $purchaseQuantity = [1 => 3, 2 => 3, 7 => 1, 10 => 1];
    $discountPrice = calcDiscountPrice('12:00', $purchaseQuantity);
    $result = calcPrice($purchaseQuantity, $discountPrice);
    $this->assertSame(1342, $result);
  }

  public function testDisplay()
  {
    $purchaseQuantity = [1 => 3, 2 => 3, 7 => 1, 10 => 1];
    $discountPrice = calcDiscountPrice('12:00', $purchaseQuantity);
    $display = calcPrice($purchaseQuantity, $discountPrice);
    $output = <<< EOD
    合計金額:1342円です。

    EOD;
    $this->expectOutputString($output);
    display($display);
  }
}
