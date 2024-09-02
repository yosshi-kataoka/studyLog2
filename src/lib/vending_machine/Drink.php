<?php

namespace VendingMachine;

require_once(__DIR__ . '/Item.php');

class Drink extends Item
{
  private const DRINK_PRICES =
  [
    'cider' => 100,
    'cola' => 150
  ];

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
    return 0;
  }
}
