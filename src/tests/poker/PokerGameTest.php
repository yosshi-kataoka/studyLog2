<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/poker/PokerGame.php');

class PokerGameTest extends TestCase
{
  public function testStart()
  {
    $game = new PokerGame(['CA', 'DA'], ['C10', 'H10']);
    $this->assertSame([['CA', 'DA'], ['C10', 'H10']], $game->start());
  }
}
