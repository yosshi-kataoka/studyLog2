<?php

namespace VendingMachine;

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

  public function purchaseConditions(int $itemPrice, int $cupNumber, Item $item): bool
  {
    if ($this->depositCoinAmount >= $itemPrice && $this->cupAmount >= $cupNumber && $item->getStockNumber() > 0) {
      return true;
    } else return false;
  }

  public function pressButton(Item $item): string
  {
    $itemPrice = $item->getPrice();
    $cupNumber = $item->getCupNumber();
    if ($this->purchaseConditions($itemPrice, $cupNumber, $item)) {
      $this->depositCoinAmount -= $itemPrice;
      $this->cupAmount -= $cupNumber;
      $item->reduceStockNumber();
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

  public function depositItem(Item $item, int $depositNumber): int
  {
    return $item->depositItem($depositNumber);
  }

  public function receiveChange(): int
  {
    $change =  $this->depositCoinAmount;
    $this->depositCoinAmount = 0;
    return $change;
  }
}
