<?php

namespace Poker;

require_once('Card.php');
require_once('Rule.php');

class TwoCardPokerRule implements Rule
{
  private const HIGH_CARD = 'high card';
  private const PAIR = 'pair';
  private const STRAIGHT = 'straight';
  private const HAND_RANKS =
  [
    'high card' => 1,
    'pair' => 2,
    'straight' => 3,
  ];

  public function getHand(array $card): array
  {
    rsort($card);
    $hands['name'] = self::HIGH_CARD;
    $hands['primary'] = $card[0];
    $hands['secondary'] = $card[1];
    if ($this->isStraight($card)) {
      $hands['name'] = self::STRAIGHT;
    }
    if ($this->isPair($card)) {
      $hands['name'] = self::PAIR;
    }
    $hands['handRank'] = self::HAND_RANKS[$hands['name']];
    return $hands;
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

  public function judgeTheWinner(array $playerHands): int
  {
    foreach (['handRank', 'primary', 'secondary'] as $k) {
      if ($playerHands[0][$k] > $playerHands[1][$k]) {
        return 1;
      } elseif ($playerHands[0][$k] < $playerHands[1][$k]) {
        return 2;
      }
    }
    return 0;
  }
}
