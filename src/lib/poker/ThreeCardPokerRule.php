<?php

namespace poker;

require_once('Card.php');
require_once('Rule.php');

class ThreeCardPokerRule implements Rule
{
  private const HIGH_CARD = 'high card';
  private const PAIR = 'pair';
  private const STRAIGHT = 'straight';
  private const THREE_OF_KIND = 'three of a kind';

  public function getHand(array $card): string
  {
    $hand = self::HIGH_CARD;
    rsort($card);

    if ($this->isThreeOfKind($card)) {
      $hand = self::THREE_OF_KIND;
    }
    if ($this->isStraight($card)) {
      $hand = self::STRAIGHT;
    }
    if ($this->isPair($card)) {
      $hand = self::PAIR;
    }
    return $hand;
  }

  public function isThreeOfKind(array $card): bool
  {
    if (count(array_unique($card)) === 1) {
      return true;
    }
    return false;
  }
  public function isContinuous(array $card): bool
  {
    if ($card[2] + 1 ===  $card[1] && $card[0] - 1 === $card[1]) {
      return true;
    }
    return false;
  }
  public function isMinMax(array $card): bool
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

  public function isPair(array $card): bool
  {
    if (count(array_unique($card)) === 2) {
      return true;
    }
    return false;
  }
}
