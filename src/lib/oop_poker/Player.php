<?php

class Player
{
  public function __construct(private string $name) {}

  public function drawCards()
  {
    // TODO:　仮実装
    return ['H10', 'D10'];
  }
}
