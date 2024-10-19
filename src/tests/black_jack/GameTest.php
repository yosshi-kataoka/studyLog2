<?php

namespace BlackJack\Tests;

require_once(__DIR__ . '../../../lib/black_jack/Game.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleA.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleB.php');

use PHPUnit\Framework\TestCase;
use BlackJack\Game;
use BlackJack\CardRuleA;
use BlackJack\CardRuleB;


class GameTest extends TestCase
{
  public function testStart()
  {
    $game = new Game();
    $result = $game->start();
    $expectingOutputString = ['あなたの負けです。' . PHP_EOL, 'あなたの勝ちです!' . PHP_EOL, '引き分けです。' . PHP_EOL];
    $this->assertContains($result, $expectingOutputString, 'いずれもふくまれておりません。');
  }
}
