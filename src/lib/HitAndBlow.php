<?php
// Hit&Blow　
// 以下はルールとなります。

// 出題者は重複した数を含まない4桁の数を決める
// 回答者は4桁の数を予想する
// 出題者は解答者の予想を判定する。数と桁の療法が同じならヒット、数だけが同じで桁が異なればブローと呼ぶ。例えば正解が1234で回答が2135なら「1ヒット、2ブロー」となる
// 上記を繰り返し行い、、4桁の数が完全に同じになるまでの回数で勝負を決める

// ◯仕様
// ヒット数とブロー数を判定するjudgeメソッドを定義。
// judgeメソッドは正解と回答を引数に受け取り、ヒット数とブロー数の配列を返します。
// 正解と回答は4桁の整数、ヒット数とブロー数は0〜4の整数とします。
// ◯実行例
// judge(5678, 5678) //=> [4, 0]
// judge(5678, 7612) //=> [1, 1]
// judge(5678, 8756) //=> [0, 4]
// judge(5678, 1234) //=> [0, 0]
// $a = [5,6,7,8]
// $b = [7,6,1,2]

// タスクばらし
// 入力値を配列に変換する。5678 => [5,6,7,8]
// $player1と$player2をforで繰り返し処理させ、要素の値をそれぞれ比較
// 最初に同じキーの値と比較し、一致していれば$hitに++
// 一致しない場合は、他のキーの要素と比較。一致していれば＄blowに++
// $hitと$blowの値を[$hit,$blow]の形で出力させる。

namespace HitAndBlow;

use Exception;

class ValidationException extends Exception {}

function validate(string $player1Inputs, string $player2Inputs): void
{
  if (!preg_match('/^\d{4}$/', $player1Inputs) || !preg_match('/^\d{4}$/', $player2Inputs)) {
    throw new
      ValidationException('数字以外が入力されているか、5桁以上の数字が入力されています。入力値は4桁の整数を重複しないように入力してください');
  }
  $player1Inputs = str_split($player1Inputs);
  $player2Inputs = str_split($player2Inputs);
  if (max(array_count_values($player1Inputs)) > 1 || max(array_count_values($player2Inputs)) > 1) {
    throw new
      ValidationException('数字が重複しています。入力値は4桁の整数を重複しないように入力してください');
  }
}

function judge(string $player1Inputs, string $player2Inputs): array
{
  $player1Input = str_split($player1Inputs);
  $player2Input = str_split($player2Inputs);
  $hit = 0;
  $blow = 0;
  for ($i = 0; $i < 4; $i++) {
    if ($player1Input[$i] === $player2Input[$i]) {
      $hit++;
      continue;
    } elseif (array_keys($player2Input, $player1Input[$i])) {
      $blow++;
    }
  }
  return [$hit, $blow];
}

// メインルーチン
try {
  $player1Inputs = "13545";
  $player2Inputs = "14795";
  validate($player1Inputs, $player2Inputs);
  judge($player1Inputs, $player2Inputs);
} catch (ValidationException $e) {
  echo 'エラー発生:' . $e->getMessage() . PHP_EOL;
}
