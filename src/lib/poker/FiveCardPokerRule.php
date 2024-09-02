<?php

namespace Poker;

require_once('Card.php');
require_once('Rule.php');

class FiveCardPokerRule implements Rule
{
  private const HIGH_CARD = 'high card';
  private const ONE_PAIR = 'one pair';
  private const TWO_PAIR = 'two pair';
  private const STRAIGHT = 'straight';
  private const THREE_OF_KIND = 'three of a kind';
  private const FULL_HOUSE = 'full house';
  private const FOUR_CARD = 'four of a kind';
  private const SAME_NUMBER_IS_FOUR = 4;
  private const SAME_NUMBER_IS_THREE = 3;
  private const IDENTICAL_NUMBER_IS_TWO = 2;
  private const ELEMENT_NUMBER_IS_THREE = 3;
  private const ELEMENT_NUMBER_IS_FOUR = 4;

  public function getHand(array $card): string
  {
    $hand = self::HIGH_CARD;
    sort($card);
    if ($this->isFourCard($card)) {
      $hand = self::FOUR_CARD;
    }
    if ($this->isFullHouse($card)) {
      $hand = self::FULL_HOUSE;
    }
    if ($this->isThreeOfKind($card)) {
      $hand = self::THREE_OF_KIND;
    }
    if ($this->isStraight($card)) {
      $hand = self::STRAIGHT;
    }
    if ($this->isTwoPair($card)) {
      $hand = self::TWO_PAIR;
    }
    if ($this->isOnePair($card)) {
      $hand = self::ONE_PAIR;
    }
    return $hand;
  }

  // カードの配列の要素数が2個かどうかを判定
  private function isTwoArrayElements(array $card): bool
  {
    if (count(array_unique($card)) === 2) {
      return true;
    }
    return false;
  }

  // 配列の要素の同じ番号の最大値を返す処理
  private function getMaxSameNumber(array $card): int
  {
    return max(array_count_values($card));
  }

  public function isFourCard(array $card): bool
  {
    if ($this->isTwoArrayElements($card) && $this->getMaxSameNumber($card) === self::SAME_NUMBER_IS_FOUR) {
      return true;
    }
    return false;
  }

  public function isFullHouse(array $card): bool
  {
    if ($this->isTwoArrayElements($card) && $this->getMaxSameNumber($card) === self::SAME_NUMBER_IS_THREE) {
      return true;
    }
    return false;
  }
  public function isThreeOfKind(array $card): bool
  {
    if (!$this->isTwoArrayElements($card) && $this->getMaxSameNumber($card) === self::SAME_NUMBER_IS_THREE) {
      return true;
    }
    return false;
  }

  // 配列の要素が連続した整数もしくは5-4-3-2-Aかどうかを判定
  public function isContinuous(array $card): bool
  {
    if (range($card[0], $card[0] + count($card) - 1) ===  $card) {
      return true;
    }
    if (range($card[0], $card[0] + count($card) - 2) === array_slice($card, 0, 4) && max($card) === max(Card::CARD_RANKS)) {
      return true;
    }
    return false;
  }

  public function isStraight(array $card): bool
  {
    if ($this->isContinuous($card)) {
      return true;
    }
    return false;
  }

  public function hasPair($card): bool
  {
    if (max(array_count_values($card)) === self::IDENTICAL_NUMBER_IS_TWO) {
      return true;
    }
    return false;
  }
  public function isTwoPair(array $card): bool
  {
    if (count(array_unique($card)) === self::ELEMENT_NUMBER_IS_THREE && $this->hasPair($card)) {
      return true;
    }
    return false;
  }

  public function isOnePair(array $card): bool
  {
    if (count(array_unique($card)) === self::ELEMENT_NUMBER_IS_FOUR) {
      return true;
    }
    return false;
  }
}
