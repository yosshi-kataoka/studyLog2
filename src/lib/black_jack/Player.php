<?php

namespace BlackJack;

require_once('User.php');
require_once('Deck.php');

use BlackJack\User;
use BlackJack\Deck;

class Player extends User
{
  public function __construct()
  {
    $this->name = 'あなた';
  }

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

  public function firstGetCardMessage(): void
  {
    foreach ($this->hands as $hand) {
      echo $this->name . 'の引いたカードは' . $hand['suit'] . 'の' . $hand['number'] . 'です.' . PHP_EOL;
    }
  }
  public function lastGetCardMessage(): void
  {
    echo $this->name . 'の引いたカードは' . end($this->hands['suit']) . 'の' . end($this->hands['number']) . 'です.' . PHP_EOL;
  }
}
