<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/oop_poker/HandEvaluator.php');
require_once(__DIR__ . '../../../lib/oop_poker/RuleA.php');
require_once(__DIR__ . '../../../lib/oop_poker/Card.php');

class HandEvaluatorTest extends TestCase
{
  public function testGetHand()
  {
    $handEvaluator = new HandEvaluator(new RuleA());
    $cards = [new Card('H', 10), new Card('C', 10)];
    $this->assertSame('pair', $handEvaluator->getHand($cards));
  }
}
