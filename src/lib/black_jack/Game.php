<?php

namespace BlackJack;

require_once(__DIR__ . '../../../lib/black_jack/Player.php');
require_once(__DIR__ . '../../../lib/black_jack/Dealer.php');
require_once(__DIR__ . '../../../lib/black_jack/Deck.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRule.php');

use BlackJack\Player;
use BlackJack\Dealer;
use BlackJack\Deck;
use BlackJack\CardRule;
use \Exception;

class Game
{
  const FIRST_DRAW_CARD_NUMBER = 2;

  public function start(): string
  {
    $this->startMessage();
    $cardRule = $this->getRule();
    list($player, $dealer, $deck) = $this->setupInstances($cardRule);
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
    if ($player->getTotalCardsNumber() < $deck->getBustNumber()) {
      $dealer->selectCardAddOrNot($deck);
    }
    $result = $deck->judgeTheWinner($player, $dealer);
    return $result;
  }

  // 処理で使用するPlayer、Dealer，Deckクラスをそれぞれインスタンス化する処理
  private function setupInstances(CardRule $cardRule): array
  {
    $player = new Player;
    $dealer = new Dealer;
    $deck = new Deck($cardRule);
    return [$player, $dealer, $deck];
  }

  private function startMessage(): void
  {
    echo 'ブラックジャックを開始します。' . PHP_EOL;
  }

  public function getRule(): CardRule
  {
    $isValid = false;
    while (!$isValid) {
      echo 'ルールA,ルールBどちらを使用しますか?' . PHP_EOL;
      echo 'ルールA:カードのAの数字は1点とします。' . PHP_EOL;
      echo 'ルールB:カードのAの数字は1点もしくは11点とし、カードの合計値が21以内で最大となる方で数えるようにします。' . PHP_EOL;
      echo 'AもしくはBにて入力してください。' . PHP_EOL;
      $input = trim(fgets(STDIN));
      try {
        if ($this->validation($input)) {
          $isValid = true;
          if (strtolower($input) === 'a') {
            echo 'ルールAが選択されました' . PHP_EOL;
            return new CardRuleA();
          } elseif (strtolower($input) === 'b') {
            echo 'ルールBが選択されました' . PHP_EOL;
            return new CardRuleB();
          }
        } elseif (!$this->validation($input)) {
          throw new Exception('入力はAもしくはBを入力してください。' . PHP_EOL);
        }
      } catch (Exception $e) {
        echo 'Error:' . $e->getMessage();
      }
    }
  }

  private function validation(string $input): bool
  {
    $inputData = strtolower($input);
    if ($inputData === 'a' || $inputData === 'b') {
      return true;
    } else {
      return false;
    }
  }
}
