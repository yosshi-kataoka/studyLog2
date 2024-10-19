<?php

namespace BlackJack\Tests;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleB.php');
require_once(__DIR__ . '../../../lib/black_jack/Dealer.php');

use PHPUnit\Framework\TestCase;
use BlackJack\Deck;
use BlackJack\CardRuleB;
use BlackJack\Dealer;


class DealerTest extends TestCase
{
  public function testDrawCard()
  {
    $cardRule = new CardRuleB();
    $deck = new Deck($cardRule);
    $dealer = new Dealer();
    $this->assertSame([['suit' => 'ハート', 'number' => 'A', 'cardRank' => 11]], $dealer->drawCard($deck));
  }

  public function testGetTotalCardsNumber()
  {
    $cardRule = new CardRuleB();
    $deck = new Deck($cardRule);
    $dealer = new Dealer();
    $dealer->drawCard($deck);
    $this->assertSame(11, $dealer->getTotalCardsNumber());
    $dealer->drawCard($deck);
    $this->assertSame(13, $dealer->getTotalCardsNumber());
  }
  public function testGetName()
  {
    $dealer = new Dealer();
    $this->assertSame('ディーラー', $dealer->getName());
  }

  public function testFirstGetCardMessage()
  {
    $dealer = new Dealer();
    $dealer->setHand('ハート', 9, 9);
    ob_start();
    $dealer->firstGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('ディーラーの引いたカードはハートの9です。' . PHP_EOL . 'ディーラーの引いた2枚目のカードはわかりません。' . PHP_EOL, $output);
  }

  public function testLastGetCardMessage()
  {
    $dealer = new Dealer();
    $dealer->setHand('ハート', 9, 9);
    $dealer->setHand('クラブ', 10, 10);
    ob_start();
    $dealer->lastGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('ディーラーの引いたカードはクラブの10です。' . PHP_EOL, $output);
  }

  public function testDisplayTotalCardsNumber()
  {
    $dealer = new Dealer();
    $dealer->setTotalCardsNumber(19);
    ob_start();
    $result = $dealer->displayTotalCardsNumber();
    $output = ob_get_clean();
    $this->assertSame('ディーラーの得点は19です。' . PHP_EOL, $output);
    $this->assertSame(19, $result);
  }
}
