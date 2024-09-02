<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Card;

require_once(__DIR__ . '../../../lib/oop_poker/Card.php');

class CardTest extends TestCase
{
  public function testGetSuit()
  {
    $card = new Card('C', 5);
    $this->assertSame('C', $card->getSuit());
  }
  public function testGetNumber()
  {
    $card = new Card('C', 5);
    $this->assertSame(5, $card->getNumber());
  }
}
