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
}
