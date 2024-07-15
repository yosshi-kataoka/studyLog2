<?php

const TAX = 0.1;
$price = 100 * (1 + TAX);
echo $price . PHP_EOL;

// 以下を実行するとエラーになります。
// const TAX = 0.2;
// $price = 100 * (1 + TAX);
// echo $price . PHP_EOL;
