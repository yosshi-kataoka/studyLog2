<?php

namespace poker;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../../lib/poker/RuleA.php');

class RuleATest extends TestCase
{
  public function testGetHand()
  {
    $rule = new RuleA();
    $this->assertSame('high card', $rule->getHand([1, 3]));
    $this->assertSame('pair', $rule->getHand([1, 1]));
    $this->assertSame('straight', $rule->getHand([2, 1]));
    $this->assertSame('straight', $rule->getHand([13, 1]));
    $this->assertSame('straight', $rule->getHand([13, 12]));
  }
}
