<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Card;

require_once(__DIR__ . '../../../lib/black_jack/Card.php');

class CardTest extends TestCase
{
  public function testDrawCard()
  {
    $card = new Card('ハート', 2);
    $this->assertSame(1, $card->start());
  }
}
