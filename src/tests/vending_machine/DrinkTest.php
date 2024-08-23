<?php

use PHPUnit\Framework\TestCase;

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
}
