<?php

namespace Bread;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../lib/Bread.php');

class BreadTest extends TestCase
{
  private $inputsData;

  protected function setUp(): void
  {
    parent::setUp();
    $_SERVER['argv'] = ['file', '1', '30', '5', '25', '9', '10', '1', '20'];
    $this->inputsData = [1 => 50, 5 => 25, 9 => 10];
  }

  public function testInputDataToPair()
  {
    $result = inputDataToPair($_SERVER['argv']);
    $this->assertSame([1 => 50, 5 => 25, 9 => 10], $result);
  }

  public function testCalculateTotalPrice()
  {
    $result = calculateTotalPrice($this->inputsData);
    var_dump($result);
    $this->assertSame(8250, $result);
  }

  public function testCalculateMaxSalesItemNumber()
  {
    $result = calculateMaxSalesItemNumber($this->inputsData);
    $this->assertSame([0 => 1], $result);
  }

  public function testCalculateMinSalesItemNumber()
  {
    $result = calculateMinSalesItemNumber($this->inputsData);
    $this->assertSame([0 => 9], $result);
  }

  public function testDisplay()
  {
    $output = <<<EOD
    合計金額:8250
    最大販売数量の商品番号:1
    最小販売数量の商品番号:9

    EOD;
    $this->expectOutputString($output);
    $totalPrice = 8250;
    $maxItemSalesNumber = [0 => 1];
    $minItemSalesNumber = [0 => 9];
    display($totalPrice, $maxItemSalesNumber, $minItemSalesNumber);
  }
}
