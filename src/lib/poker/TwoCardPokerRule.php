<?php

namespace poker;

require_once('Card.php');
require_once('Rule.php');

class TwoCardPokerRule implements Rule
{
  private const HIGH_CARD = 'high card';
  private const PAIR = 'pair';
  private const STRAIGHT = 'straight';

  public function getHand(Card $card): string
  {
    $hand = self::HIGH_CARD;
    if ($this->isStraight($this->card)) {
      $hand = self::STRAIGHT;
    }
    if ($this->isPair($card)) {
      $hand = self::PAIR;
    }
    return $hand;
  }

  public function isMinMax(array $card): bool
  {
    if (abs($card[0] - $card[1]) === (max(Card::CARD_RANKS) - min(Card::CARD_RANKS))) {
      return true;
    }
    return false;
  }
  public function isStraight(array $card): bool
  {
    if (abs($card[0] - $card[1]) === 1 || $this->isMinMax($card)) {
      return true;
    }
    return false;
  }

  public function isPair(array $card): bool
  {
    if (count(array_count_values($card)) === 1) {
      return true;
    }
    return false;
  }
}
