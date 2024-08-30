<?php

namespace poker;

interface Rule
{
  public function isStraight(array $card): bool;
  public function getHand(array $card): string;
}
