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
    $result = trim($game->start());
    var_dump($result);
    $expectingOutputString = ['あなたの負けです。', 'あなたの勝ちです!', '引き分けです。'];
    $this->assertContains($result, $expectingOutputString, 'いずれもふくまれておりません。');
  }
}
