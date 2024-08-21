<?php

class VendingMachine
{

  private const DRINK_PRICE = 100;
  private int $depositCoinAmount = 0;

  public function depositCoin(int $depositCoin): int
  {
    if ($depositCoin === 100) {
      $this->depositCoinAmount += $depositCoin;
      return $this->depositCoinAmount;
    }
    return 0;
  }

  public function pressButton(): string
  {
    if ($this->depositCoinAmount >= $this::DRINK_PRICE) {
      $this->depositCoinAmount -= $this::DRINK_PRICE;
      return 'cider';
    } else {
      return '';
    }
  }
}
