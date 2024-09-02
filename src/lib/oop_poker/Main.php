<?php

namespace OopPoker;

use OopPoker\Game;

require_once('Game.php');

$game = new Game('田中', '吉田', 2, 'A');
$game->start();
