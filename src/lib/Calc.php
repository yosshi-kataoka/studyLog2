<?php

namespace Calc;

use DateTime;
use Exception;

const PRICES =
[
    1 => ['price' => 100, 'type' => ''],
    2 => ['price' => 150, 'type' => ''],
    3 => ['price' => 200, 'type' => ''],
    4 => ['price' => 350, 'type' => ''],
    5 => ['price' => 180, 'type' => ''],
    6 => ['price' => 220, 'type' => ''],
    7 => ['price' => 440, 'type' => 'bento'],
    8 => ['price' => 380, 'type' => 'bento'],
    9 => ['price' => 80, 'type' => 'drink'],
    10 => ['price' => 100, 'type' => 'drink'],
];
const TAX = 10;
const ONION_NUMBER = 1;
const DISCOUNT_ONION_FIVE = 5;
const DISCOUNT_ONION_FIVE_PRICE = 100;
const DISCOUNT_ONION_THREE = 3;
const DISCOUNT_ONION_THREE_PRICE = 50;
const SET_DISCOUNT_PRICE = 20;
const DISCOUNT_TIME_IS_HALF = 2;
const OPENING_TIME = '09:00';
const CLOSE_TIME = '23:00';
const START_DISCOUNT_TIME = '21:00';

class ValidationException extends Exception {}

function validate(string $buyingTime, array $inputs): void
{
    if (!preg_match('/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/', $buyingTime)) {
        throw new
            ValidationException('時刻が正しく入力されてないです。時刻は21:00のように入力してください');
    }
    $buyingTime = strtotime($buyingTime);
    if ($buyingTime < strtotime(OPENING_TIME) || $buyingTime > strtotime(CLOSE_TIME)) {
        throw new
            ValidationException('時刻は9時から23時までを入力してください');
    }

    foreach ($inputs as $input) {
        if (!is_int($input)) {
            throw new
                ValidationException('商品番号が正しく入力されてないです。商品番号は1~10までの整数を入力してください');
        }
        if ($input < 1 || $input > 10) {
            throw new
                ValidationException('商品番号（1から10までの整数）以外の数字が入力されてます。');
        }
    }
    $totalBuyingPurchase = count($inputs);
    if ($totalBuyingPurchase > 20) {
        throw new
            ValidationException('購入点数が20を超えてます。購入点数は20以下になるように入力してください');
    }
}

function discountOnion(array $purchaseQuantities): int
{
    $discountOnionPrice = 0;
    if ($purchaseQuantities[ONION_NUMBER] >= DISCOUNT_ONION_FIVE) {
        $discountOnionPrice += DISCOUNT_ONION_FIVE_PRICE;
    } elseif ($purchaseQuantities[ONION_NUMBER] >= DISCOUNT_ONION_THREE) {
        $discountOnionPrice += DISCOUNT_ONION_THREE_PRICE;
    }
    return $discountOnionPrice;
}

function discountSet(int $bento, int $drink): int
{
    $discountSetPrice = (min($bento, $drink) * SET_DISCOUNT_PRICE);
    return $discountSetPrice;
}

function discountBento(int $bentoPrices): int
{
    $discountBento = $bentoPrices / DISCOUNT_TIME_IS_HALF;
    return (int)$discountBento;
}

function calcPrice(array $inputs, string $buyingTime): int
{
    $discountTime = false;
    if (strtotime($buyingTime) >= strtotime(START_DISCOUNT_TIME)) {
        $discountTime = true;
    }
    $totalPrice = 0;
    $discountPrice = 0;
    $bentoPrices = 0;
    $bento = 0;
    $drink = 0;
    $purchaseQuantities = array_count_values($inputs);
    foreach ($purchaseQuantities as $itemNumber => $purchaseQuantity) {
        $totalPrice += (PRICES[$itemNumber]['price'] * $purchaseQuantity);
        if (PRICES[$itemNumber]['type'] === 'bento') {
            $bento++;
            if ($discountTime === true) {
                $bentoPrices += PRICES[$itemNumber]['price'] * $purchaseQuantity;
            }
        }
        if (PRICES[$itemNumber]['type'] === 'drink') {
            $drink++;
        }
    }
    $discountPrice += discountOnion($purchaseQuantities);
    $discountPrice += discountSet($bento, $drink);
    if ($discountTime === true) {
        $discountPrice += discountBento($bentoPrices);
    }
    $totalPrice -= $discountPrice;
    return (int)$totalPrice * (100 + TAX) / 100;
}

function display(int $result)
{
    echo '合計金額:' . $result . '円です。' . PHP_EOL;
}

function calc(string $buyingTime, array $inputs)
{
    validate($buyingTime, $inputs);
    // $discountPrices = calcDiscountPrice($buyingTime, $purchaseQuantity);
    $result = calcPrice($inputs, $buyingTime);
    display($result);
}

// タスク
// 商品番号（1~10の整数）、金額を定数定義
// 割引に関して、$discountOnion（玉ねぎの個数に応じた値引き）、$TimeDiscount(時間に応じたお弁当の値引き),$setDiscount(お弁当と飲み物の値引き)をそれぞれ定義する
// 入力した購入時間を$buyingTime(9~23まで)として定義。
// 入力した商品番号を$purchaseQuantityとして定義
// この際、合計購入数量$totalQuantityPurchasedは20以下とする。
// 購入した商品番号をそれぞれ集計し、割引の有無を判定。割引がある場合は、集計結果より割引を行い、計算結果に消費税10%を乗じた税込金額を$pricesとして定義。
// 求めるデータ構造
// $purchaseQuantity[商品番号] =>　入力した回数　
// 例）$purchaseQuantity　＝　[1 => 4, 3 => 3, 9 => 2, ....]

// メインルーチン
try {
    $inputs = [1, 1, 1, 1, 1, 2, 2, 2, 7, 8, 10];
    // $inputs = [1, 1, 10, 3, 5, 7, 8, 9, 4];
    calc('21:00', $inputs);
} catch (ValidationException $e) {
    echo 'エラー発生:' . $e->getMessage() . PHP_EOL;
}
