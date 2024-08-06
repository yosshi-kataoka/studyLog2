<?php

// ◯お題
// あなたは小さなパン屋を営んでいました。一日の終りに売上の集計作業を行います。
// 商品は10種類あり、それぞれ金額は以下の通りです（税抜）。
// ①100
// ②120
// ③150
// ④250
// ⑤80
// ⑥120
// ⑦100
// ⑧180
// ⑨50
// ⑩300
// 一日の売上の合計（税込）と、販売個数の最も多い商品番号と販売個数の最も少ない商品番号を求めてください。
// ◯インプット
// 入力は以下の形式で与えられます。
// 販売した商品番号 販売個数 販売した商品番号 販売個数 ...
// ※ただし、販売した商品番号は1〜10の整数とする。
// ◯アウトプット
// 売上の合計
// 販売個数の最も多い商品番号
// 販売個数の最も少ない商品番号
// ※ただし、税率は10%とする。
// ※また、販売個数の最も多い商品と販売個数の最も少ない商品について、販売個数が同数の商品が存在する場合、それら全ての商品番号を記載すること。
// ◯インプット例
// 1 10 2 3 5 1 7 5 10 1
// ◯アウトプット例
// 2464
// 1
// 5 10
// ◯実行コマンド例
// php quiz.php 1 10 2 3 5 1 7 5 10 1

// プログラム作成のタスク
// 1.　コマンドラインよりデータを受取り、変数へ格納
// 2.求めるデータへ変換
// validate($breadSalesList);
// $inputs = [[1]=>10,[2]=>3,[5]=>1,... ]
// データをバリデーション処理
// 3.変換した変数より、各商品番号の合計金額および販売個数を求める。
// 合計金額
// 例)$totalPrice =1000
// 最大販売個数の商品番号および最小販売個数の商品番号(同じ数量の場合は複数個格納)
// 例)$maxSalesItemNumber = [1]
// 例）$minSalesItemNumber = [5,10]
// 4.合計金額、最大販売個数の商品番号および最小販売個数の商品番号を表示

namespace Bread;

const BREAD_ITEM_PRICES =
[
    1 => 100,
    2 => 120,
    3 => 150,
    4 => 250,
    5 => 80,
    6 => 120,
    7 => 100,
    8 => 180,
    9 => 50,
    10 => 300,
];

const MIN_BREAD_NUMBER = 1;
const MAX_BREAD_NUMBER = 10;
const MIN_BREAD_SALES_NUMBER = 1;
const TAX = 10;

// 入力値が商品番号、販売数量のペアになっているかを確認する処理
function validatePair(array $input): void
{
    if (count($input) % 2 !== 0) {
        echo 'エラー:商品番号 半角スペース 販売個数の順に入力してください。' . PHP_EOL;
        exit(1);
    }
}

// 入力値において、商品番号は1~10の整数、販売数量が1以上の整数かを確認。
function validateInputData(array $breadSalesList): void
{
    foreach ($breadSalesList as $key => $number) {
        if (!is_int($key) || !is_int($number)) {
            echo 'エラー:商品番号および販売個数には整数を入力してください。' . PHP_EOL;
            exit(1);
        }
        if (MIN_BREAD_NUMBER > $key || MAX_BREAD_NUMBER < $key || MIN_BREAD_NUMBER > $number) {
            echo 'エラー:商品番号に1~10以外の整数もしくは販売個数に1未満が入力されています。' . PHP_EOL;
            exit(1);
        }
    }
}

// コマンドラインより値を取得し、取得した配列を[商品番号]=>[販売数量]の配列に変換し、$breadNumberSalesPairsとして返す処理
function inputDataToPair(array $argv): array
{
    $input = array_slice($argv, 1);
    validatePair($input);
    $results = array_chunk($input, 2);
    $breadSalesList = [];
    foreach ($results as $result) {
        list($itemNumber, $salesNumber) = $result;
        if (isset($breadSalesList[$itemNumber])) {
            $breadSalesList[$itemNumber] += (int)$salesNumber;
            continue;
        }
        $breadSalesList[$itemNumber] = (int)$salesNumber;
    }
    validateInputData($breadSalesList);
    return $breadSalesList;
}

// 合計金額を取得する処理
function calculateTotalPrice(array $breadSalesList): int
{
    $totalPrice = 0;
    foreach ($breadSalesList as $itemNumber => $salesNumber) {
        $totalPrice += BREAD_ITEM_PRICES[$itemNumber] * $salesNumber;
    }

    return $totalPrice * (100 + TAX) / 100;
}

// 最大販売数量の商品番号を取得する処理
function calculateMaxSalesItemNumber(array $breadSalesList): array
{
    $maxSalesNumber = max(array_values($breadSalesList));
    $maxItemSalesNumber = array_keys($breadSalesList, $maxSalesNumber);
    asort($maxItemSalesNumber);
    return $maxItemSalesNumber;
}

// 最小販売数量の商品番号を取得する処理
function calculateMinSalesItemNumber(array $breadSalesList): array
{
    $minSalesNumber = min(array_values($breadSalesList));
    $minItemSalesNumber = array_keys($breadSalesList, $minSalesNumber);
    asort($minItemSalesNumber);
    return $minItemSalesNumber;
}

// 取得したそれぞれの値より、合計金額、最大販売数量、最小販売数量を表示させる処理
function display(int $totalPrice, array $maxItemSalesNumbers, array $minItemSalesNumbers): void
{
    echo '合計金額:' . $totalPrice . PHP_EOL;
    echo '最大販売数量の商品番号:';
    foreach ($maxItemSalesNumbers as $maxItemSalesNumber) {
        echo $maxItemSalesNumber . ' ';
    }
    echo PHP_EOL;
    echo '最小販売数量の商品番号:';
    foreach ($minItemSalesNumbers as $minItemSalesNumber) {
        echo $minItemSalesNumber . ' ';
    }
    echo PHP_EOL;
}

// メインルーチン
$breadSalesList = inputDataToPair($_SERVER['argv']);
$totalPrice = calculateTotalPrice($breadSalesList);
$maxItemSalesNumber = calculateMaxSalesItemNumber($breadSalesList);
$minItemSalesNumber = calculateMinSalesItemNumber($breadSalesList);
display($totalPrice, $maxItemSalesNumber, $minItemSalesNumber);
