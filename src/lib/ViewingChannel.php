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

namespace ViewingChannel;

const MIN_TOTAL_VIEWING_TIME = 0;
const MAX_TOTAL_VIEWING_TIME = 1440;
const MIN_CHANNEL_NUMBER = 1;
const MAX_CHANNEL_NUMBER = 12;
const SPLIT_MINUTE_TO_HOUR_NUMBER = 60;


function inputDataToViewChannelAndViewTime(): array
{
    $inputs = trim(fgets(STDIN));
    $input = explode(' ', $inputs);
    if (count($input) % 2 !== 0) {
        echo 'エラー:視聴番号 半角スペース 視聴時間 の順に入力されていません。' . PHP_EOL;
        echo '入力例)1 29 3 40 1 30 2 90 のように入力してください。' . PHP_EOL;
        exit(1);
    }
    $splitArrayToPairs = array_chunk($input, 2);
    return $splitArrayToPairs;
}

function calculateViewTimeParChannel(array $splitArrayToPairs): array
{
    $pairViewChannels = [];
    $count = [];
    $totalViewTime = 0;
    foreach ($splitArrayToPairs as $splitArrayToPair) {
        list($number, $viewTime) = $splitArrayToPair;
        $error = validate($splitArrayToPair);
        $totalViewTime += (int)$viewTime;
        if ($error || MIN_TOTAL_VIEWING_TIME > $totalViewTime  || $totalViewTime > MAX_TOTAL_VIEWING_TIME) {
            echo 'エラー:視聴番号が1~12以外、もしくは合計視聴時間が0~1440の範囲を超えて入力されています。' . PHP_EOL;
            exit(1);
        }
        if (isset($pairViewChannels[$number])) {
            $pairViewChannels[$number] += (int)$viewTime;
            $count[$number]++;
            continue;
        }
        $pairViewChannels[$number] = (int)$viewTime;
        $count[$number] = 1;
    }
    return [$pairViewChannels, $count, $totalViewTime];
}

function validate(array $splitArrayToPair): bool
{
    list($number, $time) = $splitArrayToPair;
    $result = false;
    if (!is_numeric($number) || !is_numeric($time)) {
        $result = true;
    } elseif (MIN_CHANNEL_NUMBER > $number || $number > MAX_CHANNEL_NUMBER) {
        $result = true;
    }
    return $result;
}

function calculateTotalHours(int $totalViewTime): float
{
    $totalViewTime = $totalViewTime / SPLIT_MINUTE_TO_HOUR_NUMBER;
    $result = round($totalViewTime, 1);
    return $result;
}

function display(array $pairViewChannel, array $count, float $totalViewTime): void
{
    echo '合計視聴時間:' . $totalViewTime . '時間' . PHP_EOL;
    ksort($pairViewChannel);
    foreach ($pairViewChannel as $number => $time) {
        echo $number . 'ch ' . $time . '分視聴' . ' 視聴回数:' . $count[$number] . '回' . PHP_EOL;
    }
}
// メインルーチン
$splitArrayToPairs = inputDataToViewChannelAndViewTime();
list($pairViewChannel, $count, $totalViewTime) = calculateViewTimeParChannel($splitArrayToPairs);
$totalViewTime = calculateTotalHours($totalViewTime);
display($pairViewChannel, $count, $totalViewTime);
