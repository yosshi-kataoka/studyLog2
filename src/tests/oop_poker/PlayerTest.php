<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/oop_poker/Player.php');

class PlayerTest extends TestCase
{
  public function testDrawCards()
  {
    $player = new Player('田中');
    $cards = $player->drawCards();
    $this->assertSame(2, count($cards));
  }
}
