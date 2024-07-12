<?php
// 入力値に対して、explode処理を行い、チャンネル番号,視聴時間がそれぞれペア(配列の要素数が偶数)になっていればtrueを返す。
function validate_input($input)
{
  $parts = explode(' ', $input);
  if (count($parts) % 2 !== 0) {
    return false;
  }

  $channel_time_pairs = array_chunk($parts, 2);
  $total_time = 0;
  foreach ($channel_time_pairs as $pair) {
    list($channel, $time) = $pair;
    if (!is_numeric($channel) || !is_numeric($time)) {
      return false;
    }
    $channel = (int) $channel;
    $time = (int) $time;
    if ($channel < 1 || $channel > 12 || $time < 0) {
      return false;
    }
    $total_time += $time;
    if ($total_time > 1440) {
      return false;
    }
  }
  return $channel_time_pairs;
}

function calculate_total_hours($channel_time_pairs)
{
  $total_minutes = 0;
  foreach ($channel_time_pairs as $pair) {
    $total_minutes += (int) $pair[1];
  }
  return $total_minutes / 60;
}

function display_channel_times($channel_time_pairs)
{
  $channel_times = [];
  foreach ($channel_time_pairs as $pair) {
    list($channel, $time) = $pair;
    if (!isset($channel_times[$channel])) {
      $channel_times[$channel] = 0;
    }
    $channel_times[$channel] += (int) $time;
  }
  ksort($channel_times);
  foreach ($channel_times as $channel => $time) {
    echo $channel . ' ' . $time . PHP_EOL;
  }
}

// メインルーチン
echo "視聴時間を入力してください: ";
$handle = fopen("php://stdin", "r");
$input = trim(fgets($handle));

$channel_time_pairs = validate_input($input);

if ($channel_time_pairs === false) {
  echo "エラー: 入力が不正です。または、視聴時間の合計が1440分を超えています。" . PHP_EOL;
  exit(1);
}

$total_hours = calculate_total_hours($channel_time_pairs);
echo $total_hours . "（時間）" . PHP_EOL;
display_channel_times($channel_time_pairs);
