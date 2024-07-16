<?php
$ages = [
  'Nakata' => 34,
  'Abe' => 25,
  'Kato' => 32,
  'Watababe' => 29,
  'Fukuzawa' => 42,
];

asort($ages);
var_dump($ages) . PHP_EOL;
krsort($ages);
var_dump($ages) . PHP_EOL;
