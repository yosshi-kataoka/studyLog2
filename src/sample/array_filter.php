<?php

$userAges = [
  'Tanaka' => 20,
  'Kimura' => 25,
  'Tabata' => 40,
];
$usersOver30 = array_filter($userAges, function ($v) {
  return $v >= 30;
});

print_r($usersOver30);
