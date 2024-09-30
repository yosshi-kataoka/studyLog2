<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Card;

require_once(__DIR__ . '../../../lib/black_jack/Card.php');

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
}
