<?php

// テレビの視聴時間に関して、下記を求めるプログラム

// 視聴番組ごとの視聴時間
// 合計視聴時間
// 視聴番組ごとの視聴回数

// 制約
// 視聴番組は1~12までの整数
// 合計視聴時間は1440以下

// 行ったこと
// 1.タスクばらし
// 標準入力にて入力値を変数へ格納
// 求める配列データに変換(この際に,制約にもとづいたバリデーション処理を実装。エラー時はプログラムを終了させる)
// 配列データより合計視聴時間および視聴番組ごとの合計視聴時間、視聴回数を求める
// 求めたデータより、視聴番号を昇順させ表示させる
// 2.求める配列データ
// [1] =>20, [3] => 50, [1] => 30 ...

const MIN_TOTAL_VIEWING_TIME = 0;
const MAX_TOTAL_VIEWING_TIME = 1440;
const MIN_CHANNEL_NUMBER = 1;
const MAX_CHANNEL_NUMBER = 12;
const SPLIT_MINUTE_TO_HOUR_NUMBER = 60;


function input_data_to_view_channel_and_view_time(): array
{
  $inputs = trim(fgets(STDIN));
  $input = explode(' ', $inputs);
  if (count($input) % 2 !== 0) {
    echo 'エラー:視聴番号 半角スペース 視聴時間 の順に入力されていません。' . PHP_EOL;
    echo '入力例)1 29 3 40 1 30 2 90 のように入力してください。' . PHP_EOL;
    exit(1);
  }
  $split_array_to_pairs = array_chunk($input, 2);
  return $split_array_to_pairs;
}

function calculate_view_time_par_channel(array $split_array_to_pairs): array
{
  $pair_view_channels = [];
  $count = [];
  $total_view_time = 0;
  foreach ($split_array_to_pairs as $split_array_to_pair) {
    list($number, $view_time) = $split_array_to_pair;
    $error = validate($split_array_to_pair);
    if (isset($pair_view_channels[$number])) {
      $pair_view_channels[$number] += (int)$view_time;
      $count[$number]++;
    } else {
      $pair_view_channels[$number] = (int)$view_time;
      $count[$number] = 1;
    }
    $total_view_time += (int)$view_time;
    if ($error || MIN_TOTAL_VIEWING_TIME > $total_view_time  || $total_view_time > MAX_TOTAL_VIEWING_TIME) {
      echo 'エラー:視聴番号が1~12以外、もしくは合計視聴時間が0~1440の範囲を超えて入力されています。' . PHP_EOL;
      exit(1);
    }
  }
  return [$pair_view_channels, $count, $total_view_time];
}

function validate(array $split_array_to_pair): bool
{
  list($number, $time) = $split_array_to_pair;
  if (!is_numeric($number) || !is_numeric($time)) {
    return true;
  } elseif (MIN_CHANNEL_NUMBER > $number || $number > MAX_CHANNEL_NUMBER) {
    return true;
  }
  return false;
}

function calculate_total_hours(int $total_view_time): float
{
  $total_view_time = $total_view_time / SPLIT_MINUTE_TO_HOUR_NUMBER;
  $result = round($total_view_time, 1);
  return $result;
}

function display(array $pair_view_channel, array $count, float $total_view_time): void
{
  echo '合計視聴時間:' . $total_view_time . '時間' . PHP_EOL;
  ksort($pair_view_channel);
  foreach ($pair_view_channel as $number => $time) {
    echo $number . 'ch ' . $time . '分視聴' . ' 視聴回数:' . $count[$number] . '回' . PHP_EOL;
  }
}
// メインルーチン
$split_array_to_pairs = input_data_to_view_channel_and_view_time();
list($pair_view_channel, $count, $total_view_time) = calculate_view_time_par_channel($split_array_to_pairs);
$total_view_time = calculate_total_hours($total_view_time);
display($pair_view_channel, $count, $total_view_time);
