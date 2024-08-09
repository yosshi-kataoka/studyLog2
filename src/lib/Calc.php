<?php

namespace Calc;

use DateTime;
use Exception;

const PRICE =
[
    1 => 100,
    2 => 150,
    3 => 200,
    4 => 350,
    5 => 180,
    6 => 220,
    7 => 440,
    8 => 380,
    9 => 80,
    10 => 100
];
const TAX = 10;
const ONION_NUMBER = 1;
const FRIED_CHICKEN_NUMBER = 7;
const NORI_BENTO_NUMBER = 8;
const GREEN_TEA_NUMBER = 9;
const COFFEE_NUMBER = 10;
const ONION_DISCOUNT_FIVE = 5;
const ONION_DISCOUNT_FIVE_PRICE = 100;
const ONION_DISCOUNT_THREE = 3;
const ONION_DISCOUNT_THREE_PRICE = 50;
const SET_DISCOUNT_PRICE = 20;
const DISCOUNT_TIME_IS_HALF = 2;
const DISCOUNT_TIME = "2100";

class ValidationException extends Exception
{
}

function sumBuyingPurchase(array $inputs): int
{
    $totalBuyingPurchase = count($inputs);
    return $totalBuyingPurchase;
    //
}

function validate(string $buyingTime, array $inputs, int $totalBuyingPurchase): void
{
    if (!preg_match('/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/', $buyingTime)) {
        throw new
            ValidationException('時刻が正しく入力されてないです。時刻は21:00のように入力してください');
    }
    foreach ($inputs as $input) {
        if (!is_int($input)) {
            throw new
                ValidationException('商品番号が正しく入力されてないです。商品番号は1~10までの整数を入力してください');
        }
    }
    if ($totalBuyingPurchase > 20) {
        throw new
            ValidationException('購入点数が20を超えてます。購入点数は20以下になるように入力してください');
    }
}

function convertToPurchaseQuantity(array $inputs): array
{
    $purchaseQuantity = [];
    foreach ($inputs as $input) {
        if (isset($purchaseQuantity[$input])) {
            $purchaseQuantity[$input]++;
            continue;
        }
        $purchaseQuantity[$input] = 1;
    }
    return $purchaseQuantity;
}

function calcDiscountPrice(string $buyingTime, array $purchaseQuantity): int
{
    $discountPrice = 0;
    $timeDiscount = false;
    $quantityOfLunchboxes = 0;
    $quantityOfDrinks = 0;
    $buyingTime = date("Hi", strtotime($buyingTime));
    if ($buyingTime >= DISCOUNT_TIME) {
        $timeDiscount = true;
    }
    if (isset($purchaseQuantity[ONION_NUMBER])) {
        if ($purchaseQuantity[ONION_NUMBER] >= ONION_DISCOUNT_FIVE) {
            $discountPrice += ONION_DISCOUNT_FIVE_PRICE;
        } elseif ($purchaseQuantity[ONION_NUMBER] >= ONION_DISCOUNT_THREE) {
            $discountPrice += ONION_DISCOUNT_THREE_PRICE;
        }
    }
    if (isset($purchaseQuantity[FRIED_CHICKEN_NUMBER])) {
        $quantityOfLunchboxes += $purchaseQuantity[FRIED_CHICKEN_NUMBER];
    } elseif (isset($purchaseQuantity[NORI_BENTO_NUMBER])) {
        $quantityOfLunchboxes += $purchaseQuantity[NORI_BENTO_NUMBER];
    }
    if (isset($purchaseQuantity[GREEN_TEA_NUMBER])) {
        $quantityOfDrinks += $purchaseQuantity[GREEN_TEA_NUMBER];
    } elseif (isset($purchaseQuantity[COFFEE_NUMBER])) {
        $quantityOfDrinks += $purchaseQuantity[COFFEE_NUMBER];
    }
    $discountPrice += (min($quantityOfLunchboxes, $quantityOfDrinks) * SET_DISCOUNT_PRICE);
    if ($timeDiscount && isset($purchaseQuantity[FRIED_CHICKEN_NUMBER])) {
        $discountPrice += $purchaseQuantity[FRIED_CHICKEN_NUMBER] * PRICE[FRIED_CHICKEN_NUMBER] / DISCOUNT_TIME_IS_HALF;
    } elseif ($timeDiscount && isset($purchaseQuantity[NORI_BENTO_NUMBER])) {
        $discountPrice += $purchaseQuantity[NORI_BENTO_NUMBER] * PRICE[NORI_BENTO_NUMBER] / DISCOUNT_TIME_IS_HALF;
    }

    return $discountPrice;
}

function calcPrice(array $purchaseQuantities, int $discountPrice): int
{
    $totalPrice = 0;
    foreach ($purchaseQuantities as $itemNumber => $purchaseQuantity) {
        $totalPrice += (PRICE[$itemNumber] * $purchaseQuantity);
    }
    $totalPrice -= $discountPrice;
    return $totalPrice * (100 + TAX) / 100;
}

function display(int $result)
{
    echo '合計金額:' . $result . '円です。' . PHP_EOL;
}

function calc(string $buyingTime, array $inputs)
{
    $totalBuyingPurchase = sumBuyingPurchase($inputs);
    validate($buyingTime, $inputs, $totalBuyingPurchase);
    $purchaseQuantity = convertToPurchaseQuantity($inputs);
    ksort($purchaseQuantity);
    $discountPrice = calcDiscountPrice($buyingTime, $purchaseQuantity);
    $result = calcPrice($purchaseQuantity, $discountPrice);
    display($result);
}

// タスク
// 商品番号（1~10の整数）、金額を定数定義
// 割引に関して、$discountOnion（玉ねぎの個数に応じた値引き）、$TimeDiscount(時間に応じたお弁当の値引き),$setDiscount(お弁当と飲み物の値引き)をそれぞれ定義する
// 入力した購入時間を$buyingTime(9~23まで)として定義。
// 入力した商品番号を$purchaseQuantityとして定義
// この際、合計購入数量$totalQuantityPurchasedは20以下とする。
// 購入した商品番号をそれぞれ集計し、割引の有無を判定。割引がある場合は、集計結果より割引を行い、計算結果に消費税10%を乗じた税込金額を$priceとして定義。
// 求めるデータ構造
// $purchaseQuantity[商品番号] =>　入力した回数　
// 例）$purchaseQuantity　＝　[1 => 4, 3 => 3, 9 => 2, ....]

// メインルーチン
try {
    $inputs = [1, 1, 1, 2, 2, 7, 10];
    // $inputs = [1, 1, 10, 3, 5, 7, 8, 9, 4];
    calc('21:00', $inputs);
} catch (ValidationException $e) {
    $e->getMessage();
}
