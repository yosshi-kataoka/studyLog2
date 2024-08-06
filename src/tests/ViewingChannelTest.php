<?php

namespace ViewingChannel;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '../../lib/ViewingChannel.php');

class ViewingChannelTest extends TestCase
{
    public function testInputDataToViewChannelAndViewTime()
    {
        $result = InputDataToViewChannelAndViewTime();
        $this->assertSame([['1', '20'], ['3', '30'], ['1', '30']], $result);
    }

    public function testCalculateViewTimeParChannel()
    {
        $inputs = [['1', '20'], ['3', '30'], ['1', '30']];
        $result = calculateViewTimeParChannel($inputs);
        $this->assertSame([1 => 50, 3 => 30], $result[0]);
        $this->assertSame(2, $result[1][1]);
        $this->assertSame(80, $result[2]);
    }

    public function testValidate()
    {
        $inputs = [1, 20];
        $result = validate($inputs);
        $this->assertSame(false, $result);
    }

    public function testCalculateTotalHours()
    {
        $time = 90;
        $result = calculateTotalHours($time);
        $this->assertSame(1.5, $result);
    }

    public function testDisplay()
    {
        $array = [1 => 60, 3 => 30];
        $count = [1 => 1, 3 => 1];
        $totalTime = 1.5;
        $output = <<<EOD
    合計視聴時間:1.5時間
    1ch 60分視聴 視聴回数:1回
    3ch 30分視聴 視聴回数:1回

    EOD;
        $this->expectOutputString($output);
        display($array, $count, $totalTime);
    }
}
