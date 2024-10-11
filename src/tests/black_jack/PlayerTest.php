<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Deck;
use BlackJack\Card;
use BlackJack\Player;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');
require_once(__DIR__ . '../../../lib/black_jack/Card.php');
require_once(__DIR__ . '../../../lib/black_jack/Player.php');

class PlayerTest extends TestCase
{
  public function testDrawCard()
  {
    $deck = new Deck();
    $player = new Player();
    $this->assertSame([['suit' => 'ハート', 'number' => 'A']], $player->drawCard($deck));
  }

  public function testGetTotalCardsNumber()
  {
    $deck = new Deck();
    $player = new Player();
    $player->drawCard($deck);
    $this->assertSame(1, $player->getTotalCardsNumber());
    $player->drawCard($deck);
    $this->assertSame(3, $player->getTotalCardsNumber());
  }
  public function testGetName()
  {
    $player = new Player();
    $this->assertSame('あなた', $player->getName());
  }
  public function testFirstGetCardMessage()
  {
    $player = new Player();
    $player->setHand('ハート', 9);
    ob_start();
    $player->firstGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('あなたの引いたカードはハートの9です。' . PHP_EOL, $output);
    $player->setHand('クラブ', 10);
    ob_start();
    $player->firstGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('あなたの引いたカードはハートの9です。' . PHP_EOL  . 'あなたの引いたカードはクラブの10です。' . PHP_EOL, $output);
  }
  public function testLastGetCardMessage()
  {
    $player = new Player();
    $player->setHand('ハート', 9);
    $player->setHand('クラブ', 10);
    ob_start();
    $player->lastGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('あなたの引いたカードはクラブの10です。' . PHP_EOL, $output);
  }
}
