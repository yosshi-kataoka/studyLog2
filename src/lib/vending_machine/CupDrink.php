<?php

namespace VendingMachine;

require_once(__DIR__ . '/Item.php');

class CupDrink extends Item
{
  private const DRINK_PRICES =
  [
    'hot cup coffee' => 100,
    'ice cup coffee' => 100
  ];
  private const MAX_STOCK_NUMBER = 50;
  private int $stockNumber = 0;

  public function __construct(string $name)
  {
    parent::__construct($name);
  }

  public function getPrice(): int
  {
    return self::DRINK_PRICES[$this->name];
  }

  public function getCupNumber(): int
  {
    return 1;
  }
  public function getStockNumber(): int
  {
    return $this->stockNumber;
  }

  public function depositItem(int $depositNumber): int
  {
    $this->stockNumber += $depositNumber;
    if ($this->stockNumber > self::MAX_STOCK_NUMBER) {
      $this->stockNumber = self::MAX_STOCK_NUMBER;
    }
    return $this->stockNumber;
  }

  public function reduceStockNumber(): void
  {
    $this->stockNumber -= 1;
  }
}
