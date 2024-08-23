<?php

require_once('Drink.php');

class VendingMachine
{

  private $depositCoinAmount = 0;
  public function depositCoin(int $depositCoin): int
  {
    if ($depositCoin === 100) {
      $this->depositCoinAmount += $depositCoin;
    }
    return $this->depositCoinAmount;
  }

  public function pressButton(Drink $drink): string
  {
    if ($this->depositCoinAmount >= $drink->getPrice()) {
      $this->depositCoinAmount -= $drink->getPrice();
      return $drink->getName();
    } else {
      return '';
    }
  }
}
