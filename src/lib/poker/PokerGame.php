<?php

namespace poker;

require_once('Card.php');
require_once('Player.php');

class PokerGame
{
  public function __construct(private array $cards1, private array $cards2) {}

  public function start(): array
  {
    $playerRanks = [];
    foreach ([$this->cards1, $this->cards2] as $cards) {
      $playerCard = new Card($cards);
      $player = new Player($playerCard);
      $playerRanks[] = $player->getNumber();
    }
    return $playerRanks;
  }
}
