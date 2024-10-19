<?php

namespace BlackJack;

require_once('User.php');
require_once('Deck.php');

use BlackJack\User;
use BlackJack\Deck;

class Dealer extends User
{

  const KEEP_DRAWING_NUMBER = 17;
  public function __construct()
  {
    $this->name = 'ディーラー';
  }

  public function drawCard(Deck $deck): array
  {
    $drawnCard = $deck->drawCard();
    $this->hands[] = $drawnCard;
    $this->calculateTotalCardNumber($this->hands, $deck);
    return $this->hands;
  }

  protected function calculateTotalCardNumber(array $hands, Deck $deck): void
  {
    list($this->hands, $this->totalCardsNumber) = $deck->calculateTotalCardNumber($hands);
  }

  public function selectCardAddOrNot(Deck $deck): void
  {
    while ($this->totalCardsNumber < self::KEEP_DRAWING_NUMBER) {
      echo $this->getName() . 'の現在の得点は' . $this->getTotalCardsNumber() . 'です。' . PHP_EOL;
      $this->drawCard($deck);
      $this->lastGetCardMessage();
    }
  }

  public function getTotalCardsNumber(): int
  {
    return $this->totalCardsNumber;
  }
  public function getName(): string
  {
    return $this->name;
  }

  //一枚目のカードは表示し、二枚目は表示しない処理
  public function firstGetCardMessage(): void
  {
    echo $this->name . 'の引いたカードは' . $this->hands[0]['suit'] . 'の' . $this->hands[0]['number'] . 'です。' . PHP_EOL;
    echo $this->name . 'の引いた2枚目のカードはわかりません。' . PHP_EOL;
  }
  // 2枚目のカードを表示する処理
  public function displaySecondCardMessage(): void
  {
    echo 'ディーラーの引いた2枚目のカードは' . $this->hands[1]['suit'] . 'の' . $this->hands[1]['number'] . 'でした。' . PHP_EOL;
  }
  // 最後に配られたカードを表示する処理
  public function lastGetCardMessage(): void
  {
    echo $this->name . 'の引いたカードは' . end($this->hands)['suit'] . 'の' . end($this->hands)['number'] . 'です。' . PHP_EOL;
  }

  public function displayTotalCardsNumber(): int
  {
    echo $this->getName() . 'の得点は' . $this->getTotalCardsNumber() . 'です。' . PHP_EOL;
    return $this->getTotalCardsNumber();
  }

  //　テストコードのみに使用するメソッド
  public function setTotalCardsNumber(int $number): void
  {
    $this->totalCardsNumber = $number;
  }

  //　テストコードのみに使用するメソッド
  public function setHand(string $suit, int $number, int $cardRank): void
  {
    $this->hands[] =  ['suit' => $suit, 'number'  => $number, 'cardRank' => $cardRank];
  }
}
