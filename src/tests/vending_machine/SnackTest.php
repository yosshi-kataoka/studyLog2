<?php

namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\Snack;

require_once(__DIR__ . '../../../lib/vending_machine/Snack.php');

class SnackTest extends TestCase
{
  public function testGetName()
  {
    $potatoChips = new Snack('potato chips');
    $this->assertSame('potato chips', $potatoChips->getName());
  }

  public function testGetPrice()
  {
    $potatoChips = new Snack('potato chips');
    $this->assertSame(150, $potatoChips->getPrice());
  }
  public function testGetCupNumber()
  {
    $potatoChips = new Snack('potato chips');
    $this->assertSame(0, $potatoChips->getCupNumber());
  }
  public function testGetStockNumber()
  {
    $potatoChips = new Snack('potato chips');
    $potatoChips->depositItem(5);
    $this->assertSame(5, $potatoChips->getStockNumber());
  }
  public function testDepositItem()
  {
    $potatoChips = new Snack('potato chips');
    $this->assertSame(5, $potatoChips->depositItem(5));
  }
  public function testReduceStockNumber()
  {
    $potatoChips = new Snack('potato chips');
    $potatoChips->depositItem(5);
    $potatoChips->reduceStockNumber();
    $this->assertSame(4, $potatoChips->getStockNumber());
  }
}
