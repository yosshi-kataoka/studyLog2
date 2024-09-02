<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\Player;
use Poker\Card;

require_once(__DIR__ . '../../../lib/poker/Player.php');

class PlayerTest extends TestCase
{
  public function testGetNumber()
  {
    $card = new Card(['H10', 'SA']);
    $player = new Player($card);
    $this->assertSame([9, 13], $player->getNumber());
  }
  public function testGetSuit()
  {
    $card = new Card(['H10', 'SA']);
    $player = new Player($card);
    $this->assertSame(['H', 'S'], $card->getSuit());
  }
}
