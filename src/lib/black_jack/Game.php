<?php

namespace BlackJack;

require_once(__DIR__ . '../../../lib/black_jack/Player.php');
require_once(__DIR__ . '../../../lib/black_jack/AutoPlayer.php');
require_once(__DIR__ . '../../../lib/black_jack/Dealer.php');
require_once(__DIR__ . '../../../lib/black_jack/Deck.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleA.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleB.php');

use BlackJack\Player;
use BlackJack\AutoPlayer;
use BlackJack\Dealer;
use BlackJack\Deck;
use BlackJack\CardRuleA;
use BlackJack\CardRuleB;
use \Exception;

class Game
{
  const FIRST_DRAW_CARD_NUMBER = 2;

  public function start(): array
  {
    $this->startMessage();
    $numberOfAutoPlayer = $this->getNumberOfAutoPlayer();
    $cardRule = $this->getRule();
    list($players, $dealer, $deck) = $this->setupInstances($cardRule, $numberOfAutoPlayer);
    $deck->shuffleCards();
    // 各ユーザーがカードを2枚引く処理
    for ($i = 0; $i < self::FIRST_DRAW_CARD_NUMBER; $i++) {
      array_map(fn($player) => $player->drawCard($deck), $players);
      $dealer->drawCard($deck);
    }
    array_map(fn($player) => $player->firstGetCardMessage(), $players);
    $dealer->firstGetCardMessage();
    array_map(fn($player) => $player->selectHitOrStand($deck), $players);
    $dealer->displaySecondCardMessage();
    if ($players[0]->getTotalCardsNumber() < $deck->getBustNumber()) {
      $dealer->selectHitOrStand($deck);
    }
    $results = $deck->judgeTheWinner($players, $dealer);
    foreach ($results as $result) {
      echo $result;
    }
    return $results;
  }

  // 処理で使用するPlayers、Dealer，Deckクラスをそれぞれインスタンス化する処理
  private function setupInstances(CardRule $cardRule, int $numberOfAutoPlayer): array
  {
    $dealer = new Dealer;
    $deck = new Deck($cardRule);
    $players = [];
    $players[] = new Player();
    if ($numberOfAutoPlayer > 0) {
      for ($i = 1; $i < ($numberOfAutoPlayer + 1); $i++) {
        $autoPlayerName = 'cpu' . $i;
        $players[] = new AutoPlayer($autoPlayerName);
      }
    }
    return [$players, $dealer, $deck];
  }

  private function startMessage(): void
  {
    echo 'ブラックジャックを開始します。' . PHP_EOL;
  }

  private function getNumberOfAutoPlayer(): int
  {
    while (true) {
      echo 'コンピューターは何人参加させますか？' . PHP_EOL;
      echo '0,1,2のいずれかを入力してください' . PHP_EOL;
      $numberOfAutoPlayer = trim(fgets(STDIN));
      $isNotError = $this->validateAutoPlayer($numberOfAutoPlayer);
      try {
        if ($isNotError) {
          return $numberOfAutoPlayer;
        } elseif (!$isNotError) {
          throw new Exception('入力値に0,1,2以外が入力されてます。' . PHP_EOL);
        }
      } catch (Exception $e) {
        echo 'Error:' . $e->getMessage();
      }
    }
  }

  private function validateAutoPlayer(string $numberOfAutoPlayer): bool
  {
    if (in_array($numberOfAutoPlayer, ['0', '1', '2'], true)) {
      return true;
    } else {
      return false;
    }
  }

  public function getRule(): CardRule
  {
    while (true) {
      echo 'ルールA,ルールBどちらを使用しますか?' . PHP_EOL;
      echo 'ルールA:カードのAの数字は1点とします。' . PHP_EOL;
      echo 'ルールB:カードのAの数字は1点もしくは11点とし、カードの合計値が21以内で最大となる方で数えるようにします。' . PHP_EOL;
      echo 'AもしくはBにて入力してください。' . PHP_EOL;
      $ruleType = trim(fgets(STDIN));
      $isNotError = $this->ValidateRule($ruleType);
      try {
        if ($isNotError) {
          if (strtolower($ruleType) === 'a') {
            echo 'ルールAが選択されました' . PHP_EOL;
            return new CardRuleA();
          } elseif (strtolower($ruleType) === 'b') {
            echo 'ルールBが選択されました' . PHP_EOL;
            return new CardRuleB();
          }
        } elseif (!$isNotError) {
          throw new Exception('入力はAもしくはBを入力してください。' . PHP_EOL);
        }
      } catch (Exception $e) {
        echo 'Error:' . $e->getMessage();
      }
    }
  }

  private function ValidateRule(string $ruleType): bool
  {
    $inputRuleType = strtolower($ruleType);
    if ($inputRuleType === 'a' || $inputRuleType === 'b') {
      return true;
    } else {
      return false;
    }
  }
}
