<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/vending_machine/VendingMachine.php');

class VendingMachineTest extends TestCase
{
  public function testDepositCoin()
  {
    $vendingMachine = new VendingMachine();
    $this->assertSame(0, $vendingMachine->depositCoin(0));
    $this->assertSame(0, $vendingMachine->depositCoin(150));
    $this->assertSame(100, $vendingMachine->depositCoin(100));
  }

  public function testPressButton()
  {
    $vendingMachine = new VendingMachine();

    // 100円を入れた場合はサイダーを購入できる
    $vendingMachine->depositCoin(100);
    $cider = new Drink('cider');
    $this->assertSame('cider', $vendingMachine->pressButton($cider));
    // 200円を入れた場合はコーラを購入できる
    $cola = new Drink('cola');
    $vendingMachine->depositCoin(100);
    $vendingMachine->depositCoin(100);
    $this->assertSame('cola', $vendingMachine->pressButton($cola));
  }
}
