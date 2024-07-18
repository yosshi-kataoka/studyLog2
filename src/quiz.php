<?php

const SPLIT_LENGTH = 2;
const MIN_CHANNEL_NUMBER = 1;
const MAX_CHANNEL_NUMBER = 12;
const MAX_VIEW_TIME = 1440;
const MINUTE_TO_TIME_NUMBER = 60;
const FIRST_DECIMAL_PLACE = 1;

// 格納データの配列を２個ペアにする処理。２個ペアにした配列を$channel_time_pairsに格納して返す。
function channel_time_to_pairs(string $inputs): array
{
  $input = explode(" ", $inputs);
  $channel_time_pairs = array_chunk($input, SPLIT_LENGTH);
  return $channel_time_pairs;
}

// 入力値に数字が入力されているかを確認。数字でない場合はfalseを返す。
function validate(int $number, int $time): bool
{
  // 入力値が数字かを判定。数字以外はfalseを返す。
  if (!is_numeric($number) || !is_numeric($time)) {
    return false;
  }
  // 視聴番号の入力値が1~12の整数かを確認。範囲外はfalseを返す。
  if (MIN_CHANNEL_NUMBER > (int)$number || (int)$number > MAX_CHANNEL_NUMBER) {
    return false;
  }
  return true;
}

// 合計視聴時間を返す処理。
function calculate_total_view_time(array $channel_time_pairs): int
{
  $total_view_time = 0;
  foreach ($channel_time_pairs as $channel_time_pair) {
    list($number, $time) = $channel_time_pair;
    // 視聴チャンネルは1~12、視聴時間合計は1440以下にてバリデーション処理を行い、範囲外はエラー表示
    $error = validate($number, $time);
    $total_view_time += (int)$time;
    // 合計視聴時間が1440を超えている場合はエラー表示を行い、処理を中断させる。
    if (!$error || $total_view_time > MAX_VIEW_TIME) {
      echo "視聴チャンネルに1~12以外を入力しているか、視聴時間の合計が1440分を超えてます。" . PHP_EOL;
      exit(1);
    }
  }
  return $total_view_time;
}

// 視聴時間をチャンネルごとに合計して表示する
function display(int $total_view_time, array $channel_time_pairs): void
{
  // 合計視聴時間を60で割って、小数点第一位までをhour表示する
  $total_view_time_hour = $total_view_time / MINUTE_TO_TIME_NUMBER;
  echo "合計視聴時間:" . round($total_view_time_hour, FIRST_DECIMAL_PLACE) . PHP_EOL;
  // 各チャンネルごとに視聴時間を表示させる。
  $result = [];
  $count = [];
  foreach ($channel_time_pairs as $results) {
    list($number, $time) = $results;
    // 同じチャンネル番号を2回以上視聴している場合、そのチャンネル番号の視聴時間を合計して、視聴回数に1を足す処理。
    // チャンネル番号が初めて出現した値の場合は、そのチャンネル番号の値に視聴時間を格納し、視聴回数を1とする処理。
    if (isset($result[$number])) {
      $result[$number] += $time;
      $count[$number]++;
    } else {
      $result[$number] = $time;
      $count[$number] = 1;
    }
  }
  ksort($result);
  foreach ($result as $key => $value) {
    echo $key . "ch " . $value . "分 " . $count[$key] . "回視聴" . PHP_EOL;
  }
}

// メインルーチン
// 入力データを変数へ格納する
echo "視聴チャンネル（1~12）およびそのチャンネルの視聴時間(分)を半角スペースで区切って入力してください。" . PHP_EOL;
echo "入力例 1 40 2 40 4 40 1 30" . PHP_EOL;
$inputs = trim(fgets(STDIN));
$channel_time_pairs = channel_time_to_pairs($inputs);
$total_view_time = calculate_total_view_time($channel_time_pairs);
display($total_view_time, $channel_time_pairs);
