<?php

namespace VendingMachine;

abstract class Item
{
  abstract public function getPrice();
  abstract public function getCupNumber();
  abstract public function getStockNumber();
  abstract public function reduceStockNumber();

  abstract public function depositItem(int $depositNumber);

  public function __construct(protected string $name) {}

  public function getName(): string
  {
    return $this->name;
  }
}
