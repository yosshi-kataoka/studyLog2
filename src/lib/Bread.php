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
// validate($bread_number_sales_pairs);
// $inputs = [[1]=>10,[2]=>3,[5]=>1,... ]
// データをバリデーション処理
// 3.変換した変数より、各商品番号の合計金額および販売個数を求める。
// 合計金額
// 例)$total_price =1000
// 最大販売個数の商品番号および最小販売個数の商品番号(同じ数量の場合は複数個格納)
// 例)$max_sales_item_number = [1]
// 例）$min_sales_item_number = [5,10]
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
function validateInputData(array $bread_number_sales_pairs): void
{
  foreach ($bread_number_sales_pairs as $key => $number) {
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

// コマンドラインより値を取得し、取得した配列を[商品番号]=>[販売数量]の配列に変換し、$bread_number_sales_pairsとして返す処理
function inputDataToPair(array $argv): array
{
  $input = array_slice($argv, 1);
  validatePair($input);
  $results = array_chunk($input, 2);
  $bread_number_sales_pairs = [];
  foreach ($results as $result) {
    list($item_number, $sales_number) = $result;
    if (isset($bread_number_sales_pairs[$item_number])) {
      $bread_number_sales_pairs[$item_number] += (int)$sales_number;
    } else {
      $bread_number_sales_pairs[$item_number] = (int)$sales_number;
    }
  }
  validateInputData($bread_number_sales_pairs);
  return $bread_number_sales_pairs;
}

// 合計金額を取得する処理
function calculateTotalPrice(array $bread_number_sales_pairs): int
{
  $total_price = 0;
  foreach ($bread_number_sales_pairs as $item_number => $sales_number) {
    $total_price += BREAD_ITEM_PRICES[$item_number] * $sales_number;
  }

  return $total_price * (100 + TAX) / 100;
}

// 最大販売数量の商品番号を取得する処理
function calculateMaxSalesItemNumber(array $bread_number_sales_pairs): array
{
  $max_sales_number = max(array_values($bread_number_sales_pairs));
  $max_item_sales_number = array_keys($bread_number_sales_pairs, $max_sales_number);
  asort($max_item_sales_number);
  return $max_item_sales_number;
}

// 最小販売数量の商品番号を取得する処理
function calculateMinSalesItemNumber(array $bread_number_sales_pairs): array
{
  $min_sales_number = min(array_values($bread_number_sales_pairs));
  $min_item_sales_number = array_keys($bread_number_sales_pairs, $min_sales_number);
  asort($min_item_sales_number);
  return $min_item_sales_number;
}

// 取得したそれぞれの値より、合計金額、最大販売数量、最小販売数量を表示させる処理
function display(int $total_price, array $max_item_sales_numbers, array $min_item_sales_numbers): void
{
  echo '合計金額:' . $total_price . PHP_EOL;
  echo '最大販売数量の商品番号:';
  foreach ($max_item_sales_numbers as $max_item_sales_number) {
    echo $max_item_sales_number . ' ';
  }
  echo PHP_EOL;
  echo '最小販売数量の商品番号:';
  foreach ($min_item_sales_numbers as $min_item_sales_number) {
    echo $min_item_sales_number . ' ';
  }
  echo PHP_EOL;
}

// メインルーチン
$bread_number_sales_pairs = inputDataToPair([$_SERVER['argv']]);
$total_price = calculateTotalPrice($bread_number_sales_pairs);
$max_item_sales_number = calculateMaxSalesItemNumber($bread_number_sales_pairs);
$min_item_sales_number = calculateMinSalesItemNumber($bread_number_sales_pairs);
display($total_price, $max_item_sales_number, $min_item_sales_number);
