<?php

namespace BlackJack\Tests;

require_once(__DIR__ . '../../../lib/black_jack/Game.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleA.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleB.php');
require_once(__DIR__ . '../../../lib/black_jack/Player.php');
require_once(__DIR__ . '../../../lib/black_jack/AutoPlayer.php');

use PHPUnit\Framework\TestCase;
use BlackJack\Game;
use BlackJack\CardRuleA;
use BlackJack\CardRuleB;
use BlackJack\Player;
use BlackJack\AutoPlayer;


class GameTest extends TestCase
{
  public function testStart()
  {
    $game = new Game();
    $results = $game->start();
    $players[] = new Player();
    $players[] = new AutoPlayer('cpu1');
    $players[] = new AutoPlayer('cpu2');
    foreach ($players as $player) {
      $expectingOutputStrings[] = [$player->getName() . 'の負けです。' . PHP_EOL, $player->getName() . 'の勝ちです!' . PHP_EOL, $player->getName() . 'は引き分けです。' . PHP_EOL];
    }
    for ($i = 0; $i < count($results); $i++) {
      $this->assertContains($results[$i], $expectingOutputStrings[$i], 'いずれもふくまれておりません。');
    }
  }
}
