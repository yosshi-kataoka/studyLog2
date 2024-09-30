<?php

namespace BlackJack;

abstract class User
{
  abstract function drawCard(Deck $deck);
}
