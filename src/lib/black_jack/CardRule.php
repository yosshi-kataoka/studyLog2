<?php

namespace BlackJack;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');

abstract class CardRule
{
  abstract public function drawCard(array $cards): array;
  abstract public function getRank(int|string $drawnCard): int;
  abstract public function calculateTotalCardNumber(array $hands): array;
  abstract public function getBustNumber(): int;
  abstract public function judgeTheWinner(Player $player, Dealer $dealer): string;
  abstract protected function isPush(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool;
  abstract protected function isWin(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool;
  abstract protected function isLoss(int $playerTotalCardsNumber, int $dealerTotalCardsNumber): bool;
}
