<?php

namespace BlackJack;

require_once('User.php');

use BlackJack\User;

class Player extends User
{
  public function drawCard()
  {
    return 1;
  }
}
