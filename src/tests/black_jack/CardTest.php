<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Card;
use BlackJack\Player;
use BlackJack\Dealer;
use BlackJack\Deck;


require_once(__DIR__ . '../../../lib/black_jack/Card.php');
require_once(__DIR__ . '../../../lib/black_jack/Player.php');
require_once(__DIR__ . '../../../lib/black_jack/Dealer.php');
require_once(__DIR__ . '../../../lib/black_jack/Deck.php');

class CardTest extends TestCase
{
  public function testDrawCard()
  {
    $card = new Card();
    $output = [['ハート', 'A']];
    $this->assertSame(['ハート', 'A'], $card->drawCard($output));
  }
  public function testGetRank()
  {
    $card = new Card();
    $this->assertSame(1, $card->getRank('A'));
    $this->assertSame(5, $card->getRank(5));
    $this->assertSame(10, $card->getRank('J'));
    $this->assertSame(10, $card->getRank('Q'));
    $this->assertSame(10, $card->getRank('K'));
  }
  public function testGetBustNumber()
  {
    $card = new Card();
    $this->assertSame(22, $card->getBustNumber());
  }

  public function testJudgeTheWinner()
  {
    $player = new Player();
    $dealer = new dealer();
    $deck = new Deck();
    //　勝敗結果が'引き分けです。'となる場合
    $player->setTotalCardsNumber(21);
    $dealer->setTotalCardsNumber(21);
    $this->assertSame('引き分けです。' . PHP_EOL, $deck->judgeTheWinner($player, $dealer));
    $player->setTotalCardsNumber(22);
    $dealer->setTotalCardsNumber(27);
    $this->assertSame('引き分けです。' . PHP_EOL, $deck->judgeTheWinner($player, $dealer));
    //　勝敗結果が'あなたの勝ちです!'となる場合
    $player->setTotalCardsNumber(21);
    $dealer->setTotalCardsNumber(18);
    $this->assertSame('あなたの勝ちです!' . PHP_EOL, $deck->judgeTheWinner($player, $dealer));
    $player->setTotalCardsNumber(21);
    $dealer->setTotalCardsNumber(23);
    $this->assertSame('あなたの勝ちです!' . PHP_EOL, $deck->judgeTheWinner($player, $dealer));
    //　勝敗結果が'あなたの負けです。'となる場合
    $player->setTotalCardsNumber(22);
    $dealer->setTotalCardsNumber(21);
    $this->assertSame('あなたの負けです。' . PHP_EOL, $deck->judgeTheWinner($player, $dealer));
    $player->setTotalCardsNumber(16);
    $dealer->setTotalCardsNumber(21);
    $this->assertSame('あなたの負けです。' . PHP_EOL, $deck->judgeTheWinner($player, $dealer));
  }
}
