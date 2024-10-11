<?php

namespace BlackJack;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');

class Card
{
  const CARD_RANKS =
  [
    'A' => 1,
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
    6 => 6,
    7 => 7,
    8 => 8,
    9 => 9,
    10 => 10,
    'J' => 10,
    'Q' => 10,
    'K' => 10,
  ];
  const BUST_NUMBER = 22;

  // private string $suit;
  // private int|string $number;

  public function drawCard(array $cards): array
  {
    return $cards[0];
  }

  public function getRank(int|string $drawnCard): int
  {
    return self::CARD_RANKS[$drawnCard];
  }

  public function getBustNumber(): int
  {
    return self::BUST_NUMBER;
  }

  public function judgeTheWinner(Player $player, Dealer $dealer): string
  {
    $playerTotalCardsNumber = $player->displayTotalCardsNumber();
    $dealerTotalCardsNumber = $dealer->displayTotalCardsNumber();
    if ($this->isPush($playerTotalCardsNumber, $dealerTotalCardsNumber)) {
      return '引き分けです。' . PHP_EOL;
    } elseif ($this->isWin($playerTotalCardsNumber, $dealerTotalCardsNumber)) {
      return  $player->getName() . 'の勝ちです!' . PHP_EOL;
    } elseif ($this->isLoss($playerTotalCardsNumber, $dealerTotalCardsNumber))
      return $player->getName() . 'の負けです。' . PHP_EOL;
  }

  private function isPush(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool
  {
    if ($playerTotalCardsNumber >= self::BUST_NUMBER && $dealerTotalCardsNumber >= self::BUST_NUMBER) {
      return true;
    } elseif ($playerTotalCardsNumber === $dealerTotalCardsNumber) {
      return true;
    } else {
      return false;
    }
  }

  private function isWin(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool
  {
    if ($playerTotalCardsNumber < self::BUST_NUMBER) {
      if ($playerTotalCardsNumber > $dealerTotalCardsNumber || $dealerTotalCardsNumber >= self::BUST_NUMBER) {
        return true;
      }
    }
    return false;
  }

  private function isLoss(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool
  {
    if ($dealerTotalCardsNumber < self::BUST_NUMBER) {
      if ($playerTotalCardsNumber < $dealerTotalCardsNumber || $playerTotalCardsNumber >= self::BUST_NUMBER) {
        return true;
      }
    }
    return false;
  }



  // public function getSuit(): string
  // {
  //   return $this->suit;
  // }

  // public function getNumber(): int|string
  // {
  //   return $this->number;
  // }
}
