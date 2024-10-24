<?php

namespace BlackJack\Tests;

require_once(__DIR__ . '../../../lib/black_jack/CardRuleA.php');
require_once(__DIR__ . '../../../lib/black_jack/Player.php');
require_once(__DIR__ . '../../../lib/black_jack/AutoPlayer.php');
require_once(__DIR__ . '../../../lib/black_jack/Dealer.php');
require_once(__DIR__ . '../../../lib/black_jack/Deck.php');

use PHPUnit\Framework\TestCase;
use BlackJack\CardRuleA;
use BlackJack\Player;
use BlackJack\AutoPlayer;
use BlackJack\Dealer;
use BlackJack\Deck;



class CardRuleATest extends TestCase
{
  public function testDrawCard()
  {
    $card = new CardRuleA();
    $output = [['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1]];
    $this->assertSame(['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1], $card->drawCard($output));
  }

  public function testGetRank()
  {
    $card = new CardRuleA();
    $this->assertSame(1, $card->getRank('A'));
    $this->assertSame(5, $card->getRank(5));
    $this->assertSame(10, $card->getRank('J'));
    $this->assertSame(10, $card->getRank('Q'));
    $this->assertSame(10, $card->getRank('K'));
  }

  public function testCalculateTotalCardNumber()
  {
    $cardRule = new CardRuleA();
    $deck = new Deck($cardRule);
    $hands =
      [
        ['suit' => 'ハート', 'number' => 10, 'cardRank' => 10],
        ['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1],
        ['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1]
      ];
    $expectOutputArray =
      [
        ['suit' => 'ハート', 'number' => 10, 'cardRank' => 10],
        ['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1],
        ['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1]
      ];
    $this->assertSame([$expectOutputArray, 12], $deck->calculateTotalCardNumber($hands));
    $hands =
      [
        ['suit' => 'ハート', 'number' => 10, 'cardRank' => 10],
        ['suit' => 'クラブ', 'number' => 'J', 'cardRank' => 10],
        ['suit' => 'スペード', 'number' => '2', 'cardRank' => 2]
      ];
    $expectOutputArray =
      [
        ['suit' => 'ハート', 'number' => 10, 'cardRank' => 10],
        ['suit' => 'クラブ', 'number' => 'J', 'cardRank' => 10],
        ['suit' => 'スペード', 'number' => '2', 'cardRank' => 2]
      ];
    $this->assertSame([$expectOutputArray, 22], $deck->calculateTotalCardNumber($hands));
  }

  public function testGetBustNumber()
  {
    $card = new CardRuleA();
    $this->assertSame(22, $card->getBustNumber());
  }

  public function testJudgeTheWinner()
  {
    $players = [];
    $players[] = new Player();
    $players[] = new AutoPlayer('cpu1');
    $players[] = new AutoPlayer('cpu2');
    $dealer = new dealer();
    $cardRule = new CardRuleA();
    $deck = new Deck($cardRule);
    //　勝敗結果が'引き分けです。'となる場合
    array_map(fn($player) => $player->setTotalCardsNumber(21), $players);
    $dealer->setTotalCardsNumber(21);
    $expectedOutputString = ['あなたは引き分けです。' . PHP_EOL, 'cpu1は引き分けです。' . PHP_EOL, 'cpu2は引き分けです。' . PHP_EOL];
    $this->assertSame($expectedOutputString, $deck->judgeTheWinner($players, $dealer));
    array_map(fn($player) => $player->setTotalCardsNumber(22), $players);
    $dealer->setTotalCardsNumber(27);
    $this->assertSame($expectedOutputString, $deck->judgeTheWinner($players, $dealer));
    //　勝敗結果が'あなたの勝ちです!'となる場合
    array_map(fn($player) => $player->setTotalCardsNumber(21), $players);
    $expectedOutputString = ['あなたは勝ちです!' . PHP_EOL, 'cpu1は勝ちです!' . PHP_EOL, 'cpu2は勝ちです!' . PHP_EOL];
    $dealer->setTotalCardsNumber(18);
    $this->assertSame($expectedOutputString, $deck->judgeTheWinner($players, $dealer));
    array_map(fn($player) => $player->setTotalCardsNumber(21), $players);
    $dealer->setTotalCardsNumber(23);
    $this->assertSame($expectedOutputString, $deck->judgeTheWinner($players, $dealer));
    //　勝敗結果が'あなたの負けです。'となる場合
    array_map(fn($player) => $player->setTotalCardsNumber(22), $players);
    $dealer->setTotalCardsNumber(21);
    $expectedOutputString = ['あなたは負けです。' . PHP_EOL, 'cpu1は負けです。' . PHP_EOL, 'cpu2は負けです。' . PHP_EOL];
    $this->assertSame($expectedOutputString, $deck->judgeTheWinner($players, $dealer));
    array_map(fn($player) => $player->setTotalCardsNumber(16), $players);
    $dealer->setTotalCardsNumber(21);
    $this->assertSame($expectedOutputString, $deck->judgeTheWinner($players, $dealer));
  }
}
