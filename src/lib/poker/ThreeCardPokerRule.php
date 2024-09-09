<?php

namespace Poker;

require_once('Card.php');
require_once('Rule.php');

class ThreeCardPokerRule implements Rule
{
  private const HIGH_CARD = 'high card';
  private const PAIR = 'pair';
  private const STRAIGHT = 'straight';
  private const THREE_CARD = 'three card';
  private const HAND_RANKS =
  [
    'high card' => 1,
    'pair' => 2,
    'straight' => 3,
    'three card' => 4,
  ];
  public function getHand(array $card): array
  {
    rsort($card);
    $hands['name'] = self::HIGH_CARD;
    $hands['primary'] = $card[0];
    $hands['secondary'] = $card[1];
    $hands['tertiary'] = $card[2];
    $hands['name'] = self::HIGH_CARD;
    if ($this->isThreeOfKind($card)) {
      $hands['name'] = self::THREE_CARD;
    }
    if ($this->isStraight($card)) {
      $hands['name'] = self::STRAIGHT;
      if ($this->isMinMax($card)) {
        $hands['primary'] = $card[1];
        $hands['secondary'] = max(Card::CARD_RANKS);
      }
    }
    if ($this->isPair($card)) {
      $hands['name'] = self::PAIR;
      if ($this->secondaryIsTertiary($card)) {
        $hands['primary'] = min($card);
        $hands['tertiary'] = max($card);
      }
    }
    $hands['handRank'] = self::HAND_RANKS[$hands['name']];
    return $hands;
  }

  public function isThreeOfKind(array $card): bool
  {
    if (count(array_unique($card)) === 1) {
      return true;
    }
    return false;
  }
  private function isContinuous(array $card): bool
  {
    if ($card[2] + 1 ===  $card[1] && $card[0] - 1 === $card[1]) {
      return true;
    }
    return false;
  }
  private function isMinMax(array $card): bool
  {
    if (abs(max($card) - min($card)) === (max(Card::CARD_RANKS) - min(Card::CARD_RANKS)) && (min($card) + 1) === $card[1]) {
      return true;
    }
    return false;
  }
  public function isStraight(array $card): bool
  {
    if ($this->isContinuous($card) || $this->isMinMax($card)) {
      return true;
    }
    return false;
  }

  private function secondaryIsTertiary(array $card): bool
  {
    if ($card[1] === $card[2]) {
      return true;
    }
    return false;
  }

  public function isPair(array $card): bool
  {
    if (count(array_unique($card)) === 2) {
      return true;
    }
    return false;
  }

  public function judgeTheWinner(array $playerHands): int
  {
    foreach (['handRank', 'primary', 'secondary', 'tertiary'] as $k) {
      if ($playerHands[0][$k] > $playerHands[1][$k]) {
        return 1;
      } elseif ($playerHands[0][$k] < $playerHands[1][$k]) {
        return 2;
      }
    }
    return 0;
  }
}
