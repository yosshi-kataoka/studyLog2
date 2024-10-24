<?php

namespace BlackJack;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');

class CardRuleB extends CardRule
{
  const CARD_RANKS =
  [
    'A' => 11,
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

  public function drawCard(array $cards): array
  {
    $cards[0]['cardRank'] = $this->getRank($cards[0]['number']);
    return $cards[0];
  }

  public function getRank(int|string $drawnCard): int
  {
    return self::CARD_RANKS[$drawnCard];
  }

  public function calculateTotalCardNumber(array $hands): array
  {
    $sum = array_sum(array_column($hands, 'cardRank'));
    foreach ($hands as &$hand) {
      if ($hand['cardRank'] === 11 && $sum >= 22) {
        $hand['cardRank'] = 1;
        $sum -= 10;
      }
    }
    return [$hands, $sum];
  }

  public function getBustNumber(): int
  {
    return self::BUST_NUMBER;
  }

  public function judgeTheWinner(array $players, Dealer $dealer): array
  {
    $result = [];
    $dealerTotalCardsNumber = $dealer->displayTotalCardsNumber();
    foreach ($players as $player) {
      $playerTotalCardsNumber = $player->displayTotalCardsNumber();
      if ($this->isPush($playerTotalCardsNumber, $dealerTotalCardsNumber)) {
        $result[] =  $player->getName() . 'は引き分けです。' . PHP_EOL;
      } elseif ($this->isWin($playerTotalCardsNumber, $dealerTotalCardsNumber)) {
        $result[] = $player->getName() . 'の勝ちです!' . PHP_EOL;
      } elseif ($this->isLoss($playerTotalCardsNumber, $dealerTotalCardsNumber)) {
        $result[] = $player->getName() . 'の負けです。' . PHP_EOL;
      }
    }
    return $result;
  }

  protected function isPush(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool
  {
    if ($playerTotalCardsNumber >= self::BUST_NUMBER && $dealerTotalCardsNumber >= self::BUST_NUMBER) {
      return true;
    } elseif ($playerTotalCardsNumber === $dealerTotalCardsNumber) {
      return true;
    } else {
      return false;
    }
  }

  protected function isWin(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool
  {
    if ($playerTotalCardsNumber < self::BUST_NUMBER) {
      if ($playerTotalCardsNumber > $dealerTotalCardsNumber || $dealerTotalCardsNumber >= self::BUST_NUMBER) {
        return true;
      }
    }
    return false;
  }

  protected function isLoss(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool
  {
    if ($dealerTotalCardsNumber < self::BUST_NUMBER) {
      if ($playerTotalCardsNumber < $dealerTotalCardsNumber || $playerTotalCardsNumber >= self::BUST_NUMBER) {
        return true;
      }
    }
    return false;
  }
}
