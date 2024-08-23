<?php

namespace poker;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/poker/Card.php');

class CardTest extends TestCase
{
  public function testGetNumber()
  {
    $card = new Card(['H10', 'SA']);
    $this->assertSame([9, 13], $card->getNumber());
  }
  public function testGetSuit()
  {
    $card = new Card(['H10', 'SA']);
    $this->assertSame(['H', 'S'], $card->getSuit());
  }
}
