<?php
// 入力値を配列に格納して返す
function inputs(): array
{
  $isValid = true;
  $inputs = [];
  while ($isValid) {
    echo '１つ目の座標の値をそれぞれ入力してください。' . PHP_EOL;
    echo 'X:';
    $inputs['x1'] = trim(fgets(STDIN));
    echo 'y:';
    $inputs['y1'] = trim(fgets(STDIN));
    echo '2つ目の座標の値をそれぞれ入力してください。' . PHP_EOL;
    echo 'X:';
    $inputs['x2'] = trim(fgets(STDIN));
    echo 'y:';
    $inputs['y2'] = trim(fgets(STDIN));
    $isValid = validate($inputs);
  }
  return $inputs;
}

// 入力値のバリデーション処理。入力値にエラーがない場合は、falseを返し、inputs()のwhileループを抜けます。
function validate($inputs): bool
{
  foreach ($inputs as $input) {
    if (!is_numeric($input)) {
      echo 'エラー:整数もしくは少数以外が入力されています。入力値には整数もしくは小数を入力してください。' . PHP_EOL;
      return true;
    }
  }
  return false;
}

// 入力値より２点間の距離を計算して、計算結果を返す処理。
function calculationDistanceBetweenTwoPoints($inputs): int|float
{
  $first_result = ($inputs['x2'] - $inputs['x1']) ** 2;
  $second_result = ($inputs['y2'] - $inputs['y1']) ** 2;
  $result = sqrt($first_result + $second_result);
  return $result;
}

// メインルーチン
echo '２点間の距離を求めるプログラムです。' . PHP_EOL;
$inputs = inputs();
$result = calculationDistanceBetweenTwoPoints($inputs);
echo "2点間の距離は" . $result . "です。" . PHP_EOL;
