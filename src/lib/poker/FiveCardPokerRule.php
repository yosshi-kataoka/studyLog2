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
  private const HAND_RANKS =
  [
    'high card' => 1,
    'one pair' => 2,
    'two pair' => 3,
    'straight' => 4,
    'three of a kind' => 5,
    'full house' => 6,
    'four of a kind' => 7,
  ];
  public function getHand(array $card): array
  {
    rsort($card);
    $hands['name'] = self::HIGH_CARD;
    $hands['primary'] = $card[0];
    $hands['secondary'] = $card[1];
    $hands['tertiary'] = $card[2];
    $hands['quaternary'] = $card[3];
    $hands['quinary'] = $card[4];
    $hands['name'] = self::HIGH_CARD;
    if ($this->isFourCard($card)) {
      $hands['name'] = self::FOUR_CARD;
      if ($hands['primary'] !== $hands['secondary']) {
        $hands['primary'] = min($card);
        $hands['secondary'] = max($card);
      } elseif ($hands['primary'] === $hands['secondary']) {
        $hands['secondary'] = min($card);
      }
    }
    if ($this->isFullHouse($card)) {
      $hands['name'] = self::FULL_HOUSE;
      $hands['secondary'] = $card[4];
    }
    if ($this->isThreeOfKind($card)) {
      $hands['name'] = self::THREE_OF_KIND;
      if ($card[0] === $card[1] && $card[0] === $card[2]) {
        $hands['secondary'] = $card[3];
        $hands['tertiary'] = $card[4];
      }
      if ($card[1] === $card[2] && $card[1] === $card[3]) {
        $hands['primary'] = $card[1];
        $hands['secondary'] = $card[0];
        $hands['tertiary'] = $card[4];
      }
      if ($card[2] === $card[3] && $card[2] === $card[4]) {
        $hands['primary'] = $card[2];
        $hands['secondary'] = $card[0];
        $hands['tertiary'] = $card[1];
      }
    }
    if ($this->isStraight($card)) {
      $hands['name'] = self::STRAIGHT;
      if ($hands['primary'] === max(Card::CARD_RANKS) && $hands['quinary'] === min(Card::CARD_RANKS)) {
        $hands['primary'] = $hands['secondary'];
        $hands['secondary'] = max(Card::CARD_RANKS);
      }
    }
    if ($this->isTwoPair($card)) {
      $hands['name'] = self::TWO_PAIR;
      if ($card[0] === $card[1]) {
        if ($card[2] === $card[3]) {
          $hands['secondary'] = $card[2];
          $hands['tertiary'] = $card[4];
        } elseif ($card[3] === $card[4]) {
          $hands['secondary'] = $card[3];
          $hands['tertiary'] = $card[2];
        }
      } elseif ($card[0] !== $card[1]) {
        $hands['primary'] = $card[1];
        $hands['secondary'] = $card[3];
        $hands['tertiary'] = $card[0];
      }
    }
    if ($this->isOnePair($card)) {
      $hands['name'] = self::ONE_PAIR;
      if ($card[0] === $card[1]) {
        $hands['secondary'] = $card[2];
        $hands['tertiary'] = $card[3];
        $hands['quaternary'] = $card[4];
      } elseif ($card[1] === $card[2]) {
        $hands['primary'] = $card[1];
        $hands['secondary'] = $card[0];
        $hands['tertiary'] = $card[3];
        $hands['quaternary'] = $card[4];
      } elseif ($card[2] === $card[3]) {
        $hands['primary'] = $card[2];
        $hands['secondary'] = $card[0];
        $hands['tertiary'] = $card[1];
        $hands['quaternary'] = $card[4];
      } elseif ($card[3] === $card[4]) {
        $hands['primary'] = $card[3];
        $hands['secondary'] = $card[0];
        $hands['tertiary'] = $card[1];
        $hands['quaternary'] = $card[2];
      }
    }
    $hands['handRank'] = self::HAND_RANKS[$hands['name']];
    return $hands;
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
    sort($card);
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
  // judgeTheWinnerメソッドは仮実装
  public function judgeTheWinner(array $playerHands): int
  {
    foreach (['handRank', 'primary', 'secondary', 'tertiary', 'quaternary', 'quinary',] as $k) {
      if ($playerHands[0][$k] > $playerHands[1][$k]) {
        return 1;
      } elseif ($playerHands[0][$k] < $playerHands[1][$k]) {
        return 2;
      }
    }
    return 0;
  }
}
