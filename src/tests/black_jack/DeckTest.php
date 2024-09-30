<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Deck;
use BlackJack\Card;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');
require_once(__DIR__ . '../../../lib/black_jack/Card.php');

class DeckTest extends TestCase
{
  public function testDrawCard()
  {
    $deck = new Deck();
    $result = $deck->drawCard();
    $this->assertSame(['suit' => 'ハート', 'number' => 'A'], $result);
  }
  public function testGetRank()
  {
    $deck = new Deck();
    $this->assertSame(1, $deck->getRank('A'));
    $this->assertSame(5, $deck->getRank(5));
    $this->assertSame(10, $deck->getRank('J'));
    $this->assertSame(10, $deck->getRank('Q'));
    $this->assertSame(10, $deck->getRank('K'));
  }
}
