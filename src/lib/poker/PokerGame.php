<?php

namespace poker;

require_once('TwoCardPOkerRule.php');
require_once('ThreeCardPOkerRule.php');
require_once('Card.php');
require_once('Player.php');
require_once('HandEvaluator.php');

class PokerGame
{
  public function __construct(private array $cards1, private array $cards2) {}

  public function start(): array
  {
    $rule = $this->getUseCardNumber();
    $playerHands = [];
    foreach ([$this->cards1, $this->cards2] as $cards) {
      $playerCard = new Card($cards);
      $player = new Player($playerCard);
      $cardRank = $player->getNumber();
      $handEvaluator = new HandEvaluator($rule);
      $playerHands[] = $handEvaluator->getHand($cardRank);
    }
    return $playerHands;
  }

  private function getUseCardNumber()
  {
    $rule = new TwoCardPokerRule();
    if (count($this->cards1) === 3) {
      $rule = new ThreeCardPokerRule();
    }
    return $rule;
  }
}
