<?php
// 格納データの配列を２個ペアにする
function channel_time_to_pairs($inputs): array
{
  $input = explode(" ", $inputs);
  $channel_time_pairs = array_chunk($input, 2);
  return $channel_time_pairs;
}

// 入力値が数字かどうかを確認。数字出ない場合はfalseを返す
function validate($number, $time): bool
{
  if (!is_numeric($number) || !is_numeric($time)) {
    return false;
  }
  // 視聴番号の入力値が1~12の整数かを確認。範囲外はfalseを返す。
  if (1 > (int)$number || (int)$number > 12) {
    return false;
  }
  return true;
}

// 合計視聴時間を返す処理。
function calculate_total_view_time($channel_time_pairs): int
{
  $total_view_time = 0;
  foreach ($channel_time_pairs as $channel_time_pair) {
    list($number, $time) = $channel_time_pair;
    // 視聴チャンネルは1~12、視聴時間合計は1440以下にてバリデーション処理を行い、範囲外はエラー表示
    $error = validate($number, $time);
    $total_view_time += (int)$time;
    if (!$error || $total_view_time > 1440) {
      echo "視聴チャンネルに1~12以外を入力しているか、視聴時間の合計が1440分を超えてます。" . PHP_EOL;
      exit(1);
    }
  }
  return $total_view_time;
}

// 視聴時間をチャンネルごとに合計して表示する
function display($total_view_time, $channel_time_pairs): void
{
  // 合計視聴時間を60で割って、小数点第一位までをhour表示する
  $total_view_time_hour = $total_view_time / 60;
  echo round($total_view_time_hour, 1) . PHP_EOL;
  // 各チャンネルごとに視聴時間を表示させる。
  $result = [];
  $count = [];
  foreach ($channel_time_pairs as $results) {
    list($number, $time) = $results;
    if (isset($result[$number])) {
      $result[$number] += $time;
      $count[$number]++;
    } else {
      $result[$number] = $time;
      $count[$number] = 1;
    }
  }
  foreach ($result as $key => $value) {
    echo $key . " " . $value . " " . $count[$key] . PHP_EOL;
  }
}

// メインルーチン
// 入力データを変数へ格納する
$inputs = trim(fgets(STDIN));
$channel_time_pairs = channel_time_to_pairs($inputs);
$total_view_time = calculate_total_view_time($channel_time_pairs);
display($total_view_time, $channel_time_pairs);
