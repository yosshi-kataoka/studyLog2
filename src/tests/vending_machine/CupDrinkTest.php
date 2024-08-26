<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/vending_machine/CupDrink.php');

class CupDrinkTest extends TestCase
{
  public function testGetName()
  {
    $hotCupCoffee = new CupDrink('ice cup coffee');
    $this->assertSame('ice cup coffee', $hotCupCoffee->getName());
  }

  public function testGetPrice()
  {
    $hotCupCoffee = new CupDrink('ice cup coffee');
    $this->assertSame(100, $hotCupCoffee->getPrice());
  }
  public function testGetCupNumber()
  {
    $hotCupCoffee = new CupDrink('ice Cup Coffee');
    $this->assertSame(1, $hotCupCoffee->getCupNumber());
  }
}
