<?php

namespace BlackJack;

require_once(__DIR__ . '../../../lib/black_jack/CardRule.php');

use BlackJack\CardRule;

class Deck
{

  private array $cards = [];

  public function __construct(private CardRule $cardRule)
  {
    // ジョーカーを除く52枚のカードを生成しシャッフルする
    foreach (['ハート', 'スペード', 'ダイヤ', 'クラブ'] as $suit) {
      foreach (['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K'] as $number) {
        $this->cards[] = ['suit' => $suit, 'number' => $number];
      }
    }
  }

  public function shuffleCards(): void
  {
    $this->cards = $this->shuffleArray();
  }

  private function shuffleArray(): array
  {
    shuffle($this->cards);
    return $this->cards;
  }

  public function drawCard(): array
  {
    // カードの配列より1枚目を取り出し、取り出した値を返す処理
    $result = $this->cardRule->drawCard($this->cards);
    $this->cards = array_slice($this->cards, 1);
    return $result;
  }

  public function getRank(int|string $drawnCard): int
  {
    return $this->cardRule->getRank($drawnCard);
  }

  public function calculateTotalCardNumber(array $hands): array
  {
    list($cardHands, $totalCardNumber) = $this->cardRule->calculateTotalCardNumber($hands);
    return [$cardHands, $totalCardNumber];
  }

  public function getBustNumber(): int
  {
    return $this->cardRule->getBustNumber();
  }

  public function judgeTheWinner(array $player, Dealer $dealer): array
  {
    return $this->cardRule->judgeTheWinner($player, $dealer);
  }

  //　テストコードでのみ使用
  public function getCards(): array
  {
    return $this->cards[0];
  }
}
