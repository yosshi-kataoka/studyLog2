<?php

namespace BlackJack\Tests;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleB.php');
require_once(__DIR__ . '../../../lib/black_jack/Player.php');

use PHPUnit\Framework\TestCase;
use BlackJack\Deck;
use BlackJack\CardRuleB;
use BlackJack\Player;


class PlayerTest extends TestCase
{
  public function testDrawCard()
  {
    $cardRule = new CardRuleB();
    $deck = new Deck($cardRule);
    $player = new Player();
    $this->assertSame([['suit' => 'ハート', 'number' => 'A', 'cardRank' => 11]], $player->drawCard($deck));
  }

  public function testGetTotalCardsNumber()
  {
    $cardRule = new CardRuleB();
    $deck = new Deck($cardRule);
    $player = new Player();
    $player->drawCard($deck);
    $this->assertSame(11, $player->getTotalCardsNumber());
    $player->drawCard($deck);
    $this->assertSame(13, $player->getTotalCardsNumber());
  }

  public function testGetName()
  {
    $player = new Player();
    $this->assertSame('あなた', $player->getName());
  }
  public function testFirstGetCardMessage()
  {
    $player = new Player();
    $player->setHand('ハート', 9, 9);
    ob_start();
    $player->firstGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('あなたの引いたカードはハートの9です。' . PHP_EOL, $output);
    $player->setHand('クラブ', 10, 10);
    ob_start();
    $player->firstGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('あなたの引いたカードはハートの9です。' . PHP_EOL  . 'あなたの引いたカードはクラブの10です。' . PHP_EOL, $output);
  }
  public function testLastGetCardMessage()
  {
    $player = new Player();
    $player->setHand('ハート', 9, 9);
    $player->setHand('クラブ', 10, 10);
    ob_start();
    $player->lastGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('あなたの引いたカードはクラブの10です。' . PHP_EOL, $output);
  }

  public function testDisplayTotalCardsNumber()
  {
    $player = new Player();
    $player->setTotalCardsNumber(19);
    ob_start();
    $result = $player->displayTotalCardsNumber();
    $output = ob_get_clean();
    $this->assertSame('あなたの得点は19です。' . PHP_EOL, $output);
    $this->assertSame(19, $result);
  }
}
