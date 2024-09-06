<?php

namespace Poker;

interface Rule
{
  public function isStraight(array $card): bool;
  public function getHand(array $card): array;
  public function judgeTheWinner(array $card): int;
}
