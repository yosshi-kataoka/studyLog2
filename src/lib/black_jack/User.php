<?php

namespace BlackJack;

abstract class User
{
  protected array $hands = [];
  protected int $totalCardsNumber = 0;
  protected string $name = '';
  abstract function drawCard(Deck $deck): array;
  abstract function selectCardAddOrNot(Deck $deck): void;
  abstract function getTotalCardsNumber(): int;
  abstract function getName(): string;
  abstract function firstGetCardMessage(): void;
  abstract function lastGetCardMessage(): void;
  abstract function displayTotalCardsNumber(): void;
}
