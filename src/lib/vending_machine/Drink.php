<?php

class Drink
{

  private const DRINK_PRICE =
  [
    'cider' => 100,
    'cola' => 150
  ];

  public function __construct(private string $name) {}

  public function getName()
  {
    return $this->name;
  }

  public function getPrice()
  {
    return self::DRINK_PRICE[$this->name];
  }
}
