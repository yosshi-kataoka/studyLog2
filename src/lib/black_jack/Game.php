<?php

namespace BlackJack;

class Game
{
  public function start()
  {
    $this->startMessage();
    $player = new Player;
    // $dealer = new Dealer;
    $deck = new Deck();
    $deck->shuffleCards();
    for ($i = 0; $i < 2; $i++) {
      $player->drawCard($deck);
      // $dealer->drawCard($deck);
    }
    $player->getCardMessage();
    return 1;
  }
  private function startMessage()
  {
    echo 'ブラックジャックを開始します。' . PHP_EOL;
  }
}
