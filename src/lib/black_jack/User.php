<?php

namespace BlackJack;

abstract class User
{
  protected array $hands = [];
  protected int $totalCardsNumber = 0;
  protected string $name = '';

  abstract public function drawCard(Deck $deck): array;
  abstract protected function calculateTotalCardNumber(array $hands, Deck $deck): void;
  abstract public function selectHitOrStand(Deck $deck): void;
  abstract public function getTotalCardsNumber(): int;
  abstract public function getName(): string;
  abstract public function firstGetCardMessage(): void;
  abstract public function lastGetCardMessage(): void;
  abstract public function displayTotalCardsNumber(): int;
  abstract public function setTotalCardsNumber(int $number): void;
  abstract public function setHand(string $suit, int $number, int $cardRank): void;
}
