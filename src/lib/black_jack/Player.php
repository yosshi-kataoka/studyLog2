<?php

namespace BlackJack;

require_once('User.php');
require_once('Deck.php');

use BlackJack\User;
use BlackJack\Deck;

class Player extends User
{
  private array $hands = [];
  private int $totalCardsNumber = 0;

  public function drawCard(Deck $deck): array
  {
    $drawnCard = $deck->drawCard();
    $this->totalCardsNumber += $deck->getRank($drawnCard['number']);
    $this->hands[] = $drawnCard;
    return $this->hands;
  }

  public function getTotalCardsNumber(): int
  {
    return $this->totalCardsNumber;
  }
}
