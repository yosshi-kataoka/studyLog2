<?php

require_once('Player.php');

class Game
{
  public function __construct(private string $name1, private string $name2) {}
  public function start()
  {
    // プレイヤーを登録する
    $player1 = new Player($this->name1);
    $player2 = new Player($this->name2);
    // プレイヤーがカードを引く
    $cards1 = $player1->drawCards();
    $cards2 = $player2->drawCards();
    return [$cards1, $cards2];
  }
}
