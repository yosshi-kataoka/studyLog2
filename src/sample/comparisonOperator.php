<?php

$number = 1;
// $numberに1を足してechoさせる。下記では2が表示される
echo ++$number . PHP_EOL;
// $numberに2を足して$numberに格納。echoでは4が表示される。
$number += 2;
echo $number . PHP_EOL;

// 緩やかな比較では型は関係ないため、値が一致していればよい。そのためtrueが表示
var_dump($number == '4');
// 厳密な比較では、$numberには数字の4が格納されているため、falseが表示
var_dump($number === '4');
