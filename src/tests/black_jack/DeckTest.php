<?php

namespace BlackJack\Tests;

require_once(__DIR__ . '../../../lib/black_jack/Deck.php');
require_once(__DIR__ . '../../../lib/black_jack/CardRuleB.php');

use PHPUnit\Framework\TestCase;
use BlackJack\Deck;
use BlackJack\CardRuleB;
use ReflectionMethod;


class DeckTest extends TestCase
{
  public function testShuffleCards()
  {
    $cardRule = new CardRuleB();
    $deck  = new Deck($cardRule);
    $deck->shuffleCards();
    $this->assertNotSame(['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1], $deck->getCards());
  }

  public function testShuffleArray()
  {
    $cardRule = new CardRuleB();
    $method = new ReflectionMethod(Deck::class, 'shuffleArray');
    $method->setAccessible(true);
    $output = $method->invoke(new Deck($cardRule));
    $this->assertNotSame(['suit' => 'ハート', 'number' => 'A', 'cardRank' => 11], $output[0]);
  }

  public function testDrawCard()
  {
    $cardRule = new CardRuleB();
    $deck = new Deck($cardRule);
    $result = $deck->drawCard();
    $this->assertSame(['suit' => 'ハート', 'number' => 'A', 'cardRank' => 11], $result);
  }

  public function testGetRank()
  {
    $cardRule = new CardRuleB();
    $deck = new Deck($cardRule);
    $this->assertSame(11, $deck->getRank('A'));
    $this->assertSame(5, $deck->getRank(5));
    $this->assertSame(10, $deck->getRank('J'));
    $this->assertSame(10, $deck->getRank('Q'));
    $this->assertSame(10, $deck->getRank('K'));
  }

  public function testCalculateTotalCardNumber()
  {
    $cardRule = new CardRuleB();
    $deck = new Deck($cardRule);
    // $handsに任意の値をセットし、テストを実行
    $hands =
      [
        ['suit' => 'ハート', 'number' => 10, 'cardRank' => 10],
        ['suit' => 'ハート', 'number' => 'A', 'cardRank' => 11],
        ['suit' => 'ハート', 'number' => 'A', 'cardRank' => 11]
      ];
    $expectOutputArray =
      [
        ['suit' => 'ハート', 'number' => 10, 'cardRank' => 10],
        ['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1],
        ['suit' => 'ハート', 'number' => 'A', 'cardRank' => 1]
      ];

    $this->assertSame([$expectOutputArray, 12], $deck->calculateTotalCardNumber($hands));
  }

  public function testGetBustNumber()
  {
    $cardRule = new CardRuleB();
    $deck = new Deck($cardRule);
    $this->assertSame(22, $deck->getBustNumber());
  }
}
