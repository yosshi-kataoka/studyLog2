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
}
