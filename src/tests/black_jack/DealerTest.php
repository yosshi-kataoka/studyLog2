<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Deck;
use BlackJack\Card;
use BlackJack\Dealer;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');
require_once(__DIR__ . '../../../lib/black_jack/Card.php');
require_once(__DIR__ . '../../../lib/black_jack/Dealer.php');

class DealerTest extends TestCase
{
  public function testDrawCard()
  {
    $deck = new Deck();
    $dealer = new Dealer();
    $this->assertSame([['suit' => 'ハート', 'number' => 'A']], $dealer->drawCard($deck));
  }

  public function testGetTotalCardsNumber()
  {
    $deck = new Deck();
    $dealer = new Dealer();
    $dealer->drawCard($deck);
    $this->assertSame(1, $dealer->getTotalCardsNumber());
    $dealer->drawCard($deck);
    $this->assertSame(3, $dealer->getTotalCardsNumber());
  }
  public function testGetName()
  {
    $dealer = new Dealer();
    $this->assertSame('ディーラー', $dealer->getName());
  }

  public function testFirstGetCardMessage()
  {
    $dealer = new Dealer();
    $dealer->setHand('ハート', 9);
    ob_start();
    $dealer->firstGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('ディーラーの引いたカードはハートの9です。' . PHP_EOL . 'ディーラーの引いた2枚目のカードはわかりません。' . PHP_EOL, $output);
  }

  public function testLastGetCardMessage()
  {
    $dealer = new Dealer();
    $dealer->setHand('ハート', 9);
    $dealer->setHand('クラブ', 10);
    ob_start();
    $dealer->lastGetCardMessage();
    $output = ob_get_clean();
    $this->assertSame('ディーラーの引いたカードはクラブの10です。' . PHP_EOL, $output);
  }
}
