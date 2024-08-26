<?php

namespace poker;

interface Rule
{
  public function isMinMax(array $card): bool;
  public function isStraight(array $card): bool;
  public function isPair(array $card): bool;
  public function getHand(array $card): string;
}
