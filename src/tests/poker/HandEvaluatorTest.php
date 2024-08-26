<?php

namespace poker;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/poker/HandEvaluator.php');
require_once(__DIR__ . '../../../lib/poker/Rule.php');

class HandEvaluatorTest extends TestCase
{
  public function testGetHand()
  {
    $rule = new RuleA();
    $handEvaluator = new HandEvaluator($rule);
    $this->assertSame('high card', $handEvaluator->getHand([1, 3]));
    $this->assertSame('pair', $handEvaluator->getHand([1, 1]));
    $this->assertSame('straight', $handEvaluator->getHand([2, 1]));
    $this->assertSame('straight', $handEvaluator->getHand([13, 1]));
    $this->assertSame('straight', $handEvaluator->getHand([13, 12]));
  }
}
