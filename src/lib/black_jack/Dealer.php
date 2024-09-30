<?php

namespace BlackJack;

require_once('User.php');
require_once('Deck.php');

use BlackJack\User;
use BlackJack\Deck;

class Dealer extends User
{
  public function __construct()
  {
    $this->name = 'ディーラー';
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

  //仮実装 一枚目は開示、二枚目は伏せる処理を今後実装
  public function getCardMessage(): void
  {
    foreach ($this->hands as $hand) {
      echo $this->name . 'の引いたカードは' . $hand['suit'] . 'の' . $hand['number'] . 'です.' . PHP_EOL;
    }
  }
}
