<?php

require_once('Snack.php');

class PotatoChips extends Snack
{
  private const PRICES =
  [
    'potatoChips' => 150
  ];

  public function __construct(string $name)
  {
    parent::__construct($name);
  }

  public function getPrice(): int
  {
    return self::PRICES[$this->name];
  }

  public function getCupNumber(): int
  {
    return 0;
  }
}
