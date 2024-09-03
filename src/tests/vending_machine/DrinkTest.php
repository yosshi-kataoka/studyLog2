<?php

namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\Drink;

require_once(__DIR__ . '../../../lib/vending_machine/Drink.php');

class DrinkTest extends TestCase
{
  public function testGetName()
  {
    $cider = new Drink('cider');
    $this->assertSame('cider', $cider->getName());
  }

  public function testGetPrice()
  {
    $cider = new Drink('cider');
    $this->assertSame(100, $cider->getPrice());
  }
  public function testGetCupNumber()
  {
    $cider = new Drink('cider');
    $this->assertSame(0, $cider->getCupNumber());
  }

  public function testGetStockNumber()
  {
    $drink = new Drink('cider');
    $drink->depositItem(5);
    $this->assertSame(5, $drink->getStockNumber());
  }
  public function testDepositItem()
  {
    $drink = new Drink('cider');
    $this->assertSame(5, $drink->depositItem(5));
  }
  public function testReduceStockNumber()
  {
    $drink = new Drink('cider');
    $drink->depositItem(5);
    $drink->reduceStockNumber();
    $this->assertSame(4, $drink->getStockNumber());
  }
}
