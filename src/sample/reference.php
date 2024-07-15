<?php
$a = "php";
$b = $a;
$a = "Ruby";
echo $a . PHP_EOL;
echo $b . PHP_EOL;
// $aは"Ruby",$bは"php"が出力される

// 以下はリファレンス使用の場合
$c = "php";
$d = &$c;
$c = "Ruby";
echo $c . PHP_EOL;
echo $d . PHP_EOL;
// $c,$dともに"Ruby"が出力される
