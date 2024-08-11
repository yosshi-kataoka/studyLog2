<?php

namespace HitAndBlow;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../lib/HitAndBlow.php');

class HitAndBlowTest extends TestCase
{
  public function testJudge()
  {
    $this->assertSame([0, 0], judge(1234, 5678));
    $this->assertSame([4, 0], judge(1234, 1234));
    $this->assertSame([0, 4], judge(1234, 4321));
    $this->assertSame([1, 1], judge(1234, 4289));
  }
}
