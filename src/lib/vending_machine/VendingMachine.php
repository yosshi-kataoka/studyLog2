<?php

require_once(__DIR__ . '/Item.php');
require_once(__DIR__ . '../../../lib/vending_machine/CupDrink.php');

class VendingMachine
{
  private const MAX_CUP_AMOUNT = 100;
  private int $cupAmount = 0;
  private int $depositCoinAmount = 0;

  public function depositCoin(int $depositCoin): int
  {
    if ($depositCoin === 100) {
      $this->depositCoinAmount += $depositCoin;
    }
    return $this->depositCoinAmount;
  }

  public function pressButton(Item $item): string
  {
    $itemPrice = $item->getPrice();
    $cupNumber = $item->getCupNumber();
    if ($this->depositCoinAmount >= $itemPrice && $this->cupAmount >= $cupNumber) {
      $this->depositCoinAmount -= $itemPrice;
      $this->cupAmount -= $cupNumber;
      return $item->getName();
    } else {
      return '';
    }
  }

  public function addCup(int $addCupNumber): int
  {
    $cupNumber = $this->cupAmount += $addCupNumber;
    if ($cupNumber > self::MAX_CUP_AMOUNT) {
      $cupNumber = self::MAX_CUP_AMOUNT;
    }
    $this->cupAmount = $cupNumber;
    return $this->cupAmount;
  }
}
