<?php

namespace Poker;

require_once('Card.php');
class Player
{
  public function __construct(private Card $cards) {}

  public function getNumber()
  {
    return $this->cards->getNumber();
  }
  public function getSuit()
  {
    return $this->cards->getSuit();
  }
}
