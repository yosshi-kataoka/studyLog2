<?php

namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\CupDrink;

require_once(__DIR__ . '../../../lib/vending_machine/CupDrink.php');

class CupDrinkTest extends TestCase
{
  public function testGetName()
  {
    $iceCupCoffee = new CupDrink('ice cup coffee');
    $this->assertSame('ice cup coffee', $iceCupCoffee->getName());
  }

  public function testGetPrice()
  {
    $iceCupCoffee = new CupDrink('ice cup coffee');
    $this->assertSame(100, $iceCupCoffee->getPrice());
  }
  public function testGetCupNumber()
  {
    $iceCupCoffee = new CupDrink('ice cup coffee');
    $this->assertSame(1, $iceCupCoffee->getCupNumber());
  }
  public function testGetStockNumber()
  {
    $iceCupCoffee = new CupDrink('ice cup coffee');
    $iceCupCoffee->depositItem(5);
    $this->assertSame(5, $iceCupCoffee->getStockNumber());
  }
  public function testDepositItem()
  {
    $iceCupCoffee = new CupDrink('ice cup coffee');
    $this->assertSame(5, $iceCupCoffee->depositItem(5));
  }
  public function testReduceStockNumber()
  {
    $iceCupCoffee = new CupDrink('ice cup coffee');
    $iceCupCoffee->depositItem(5);
    $iceCupCoffee->reduceStockNumber();
    $this->assertSame(4, $iceCupCoffee->getStockNumber());
  }
}
