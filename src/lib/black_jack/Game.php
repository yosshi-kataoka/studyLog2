<?php

namespace BlackJack;

require_once(__DIR__ . '../../../lib/black_jack/Player.php');
require_once(__DIR__ . '../../../lib/black_jack/Dealer.php');
require_once(__DIR__ . '../../../lib/black_jack/Deck.php');

use BlackJack\Player;
use BlackJack\Dealer;
use BlackJack\Deck;
use Exception;

class Game
{
  const FIRST_DRAW_CARD_NUMBER = 2;

  public function start()
  {
    $this->startMessage();
    list($player, $dealer, $deck) = $this->setupInstances();
    $deck->shuffleCards();
    // 各ユーザーがカードを2枚引く処理
    for ($i = 0; $i < self::FIRST_DRAW_CARD_NUMBER; $i++) {
      $player->drawCard($deck);
      $dealer->drawCard($deck);
    }
    $player->firstGetCardMessage();
    $dealer->firstGetCardMessage();
    $player->selectCardAddOrNot($deck);
    $dealer->displaySecondCardMessage();
    $dealer->selectCardAddOrNot($deck);
    $deck->judgeTheWinner($player, $dealer);

    return 1;
  }
  // 処理で使用するPlayer、Dealer，Deckクラスをそれぞれインスタンス化する処理
  private function setupInstances()
  {
    $player = new Player;
    $dealer = new Dealer;
    $deck = new Deck();
    return [$player, $dealer, $deck];
  }

  private function startMessage()
  {
    echo 'ブラックジャックを開始します。' . PHP_EOL;
  }
}
