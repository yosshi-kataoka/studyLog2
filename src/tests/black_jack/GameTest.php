<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Game;

require_once(__DIR__ . '../../../lib/black_jack/Game.php');

class GameTest extends TestCase
{
  public function testStart()
  {
    $game = new Game();
    $this->assertSame(1, $game->start());
  }
}
