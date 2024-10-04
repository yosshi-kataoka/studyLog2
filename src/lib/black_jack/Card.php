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

  public function judgeTheWinner(Player $player, Dealer $dealer)
  {
    $player->displayTotalCardsNumber();
    $dealer->displayTotalCardsNumber();
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
