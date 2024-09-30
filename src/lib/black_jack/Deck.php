<?php

namespace BlackJack;

use BlackJack\Card;

require_once(__DIR__ . '../../../lib/black_jack/Card.php');

class Deck
{

  private array $cards = [];

  public function __construct(private Card $card = new Card())
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
    $result = $this->card->drawCard($this->cards);
    $this->cards = array_slice($this->cards, 1);
    return $result;
  }

  public function getRank(int|string $drawnCard): int
  {
    return $this->card->getRank($drawnCard);
  }
}
