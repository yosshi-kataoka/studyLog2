<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Deck;

require_once(__DIR__ . '../../../lib/oop_poker/Deck.php');

class DeckTest extends TestCase
{
  public function testDrawCards()
  {
    $deck = new Deck();
    $cards = $deck->drawCards(2);
    $this->assertSame(2, count($cards));
  }
}
