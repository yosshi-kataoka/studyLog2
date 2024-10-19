<?php

namespace BlackJack;

require_once('User.php');
require_once('Deck.php');

use BlackJack\User;
use BlackJack\Deck;
use \Exception;

class Player extends User
{
  public function __construct()
  {
    $this->name = 'あなた';
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

  // カードを追加するかしないかを選択する処理
  public function selectCardAddOrNot(Deck $deck): void
  {
    while (true) {
      // カードの合計を計算する処理を実装
      echo $this->getName() . 'の現在の得点は' . $this->getTotalCardsNumber() . 'です。カードを引きますか？(Y/N)' . PHP_EOL;
      try {
        $inputValue = trim(fgets(STDIN));
        if ($this->inputValidation($inputValue)) {
          $this->drawCard($deck);
          $this->lastGetCardMessage();
          if ($this->getTotalCardsNumber() >= $deck->getBustNumber()) {
            break;
          }
        } elseif (!$this->inputValidation($inputValue)) {
          break;
        }
      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }
  }

  // 入力内容に応じて真偽値を返す処理
  // 入力値に例外があった場合の例外処理も実装
  protected function inputValidation(string $inputValue): bool
  {
    $inputData = strtolower($inputValue);
    if ($inputData === 'y' || $inputData === 'yes') {
      return true;
    } elseif ($inputData === 'n' || $inputData === 'no') {
      return false;
    } else {
      throw new Exception('入力が正しくありません。y(yes)もしくはn(no)を入力してください。');
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

  // 最初に配られた2枚のカードを表示する処理
  public function firstGetCardMessage(): void
  {
    foreach ($this->hands as $hand) {
      echo $this->name . 'の引いたカードは' . $hand['suit'] . 'の' . $hand['number'] . 'です。' . PHP_EOL;
    }
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
