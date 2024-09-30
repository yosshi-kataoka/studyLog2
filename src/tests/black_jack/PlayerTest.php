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
}
