<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Game;

require_once(__DIR__ . '../../../lib/oop_poker/Game.php');

class GameTest extends TestCase
{
  public function testStart()
  {
    $game = new Game('田中', '吉田', 2, 'A');
    $result = $game->start();
    $this->assertSame(1, $result);
  }
}
