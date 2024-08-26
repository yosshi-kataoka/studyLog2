<?php

namespace poker;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/poker/PokerGame.php');

class PokerGameTest extends TestCase
{
  public function testStart()
  {
    $game = new PokerGame(['CA', 'DA'], ['CA', 'H2']);
    $this->assertSame(['pair', 'straight'], $game->start());
  }
}
