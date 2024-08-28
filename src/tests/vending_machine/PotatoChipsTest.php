<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/vending_machine/PotatoChips.php');

class PotatoChipsTest extends TestCase
{
  public function testGetName()
  {
    $potatoChips = new PotatoChips('potatoChips');
    $this->assertSame('potatoChips', $potatoChips->getName());
  }

  public function testGetPrice()
  {
    $potatoChips = new PotatoChips('potatoChips');
    $this->assertSame(150, $potatoChips->getPrice());
  }
  public function testGetCupNumber()
  {
    $potatoChips = new PotatoChips('potatoChips');
    $this->assertSame(0, $potatoChips->getCupNumber());
  }
}
