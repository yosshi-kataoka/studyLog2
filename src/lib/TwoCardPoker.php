<?php

// ◯お題
// 2枚の手札でポーカーを行います。ルールは次の通りです。
// ・プレイヤーは2人です
// ・各プレイヤーはトランプ2枚を与えられます
// ・ジョーカーはありません
// ・与えられたカードから、役を判定します。役は番号が大きくなるほど強くなります
// ハイカード：以下の役が一つも成立していない
// ペア：2枚のカードが同じ数字
// ストレート：2枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2 と K-A の2つです
// ・2つの手札について、強さは以下に従います
// 2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
// 2つの手札の役が同じ場合、各カードの数値によって強さを比較する
// 　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
// 　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、もう一枚のカード同士を比較する
// 　 ・ペア：ペアの数字を比較する
// 　 ・ストレート：一番強い数字を比較する (ただし、A-2 の組み合わせの場合、2 を一番強い数字とする。K-A が最強、A-2 が最弱)
// 　 ・数値が同じ場合：引き分け
// それぞれの役と勝敗を判定するプログラムを作成ください。
// ◯仕様
// それぞれの役と勝敗を判定するshowDownメソッドを定義してください。
// showDownメソッドは引数として、プレイヤー1のカード、プレイヤー1のカード、プレイヤー2のカード、プレイヤー2のカードを取ります。
// カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。ただし、Jは11、Qは12、Kは13、Aは1とします。
// showDownメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。

// ◯実行例
// showDown('CK', 'DJ', 'C10', 'H10')  //=> ['high card', 'pair', 2]
// showDown('CK', 'DJ', 'C3', 'H4')    //=> ['high card', 'straight', 2]
// showDown('C3', 'H4', 'DK', 'SK')    //=> ['straight', 'pair', 1]
// showDown('HJ', 'SK', 'DQ', 'D10')   //=> ['high card', 'high card', 1]
// showDown('H9', 'SK', 'DK', 'D10')   //=> ['high card', 'high card', 2]
// showDown('H3', 'S5', 'D5', 'D3')    //=> ['high card', 'high card', 0]
// showDown('CA', 'DA', 'C2', 'D2')    //=> ['pair', 'pair', 1]
// showDown('CK', 'DK', 'CA', 'DA')    //=> ['pair', 'pair', 2]
// showDown('C4', 'D4', 'H4', 'S4')    //=> ['pair', 'pair', 0]
// showDown('SA', 'DK', 'C2', 'CA')    //=> ['straight', 'straight', 1]
// showDown('C2', 'CA', 'S2', 'D3')    //=> ['straight', 'straight', 2]
// showDown('S2', 'D3', 'C2', 'H3')    //=> ['straight', 'straight', 0]

// タスクばらし
// 1~13(J:11,Q:12,K:13,A:1)までのCardの強さを定数$CARD_STRENGTHとして定義
// 役の判定(文字列の各2つ目がCardの数字のため、こちらをプレイヤーごとのCard1、Card2で比較し、役の判定を条件分岐させて行う）
// 同じ役だった場合、数字が大きい方が勝利のため、max関数を使用してプレイヤーの手札のCardを比較し、返り値($cardStrength)が大きい方が勝利となる
// 役がストレートで、Cardの数字がA,2の場合、この組み合わせはストレートの中で一番弱い強さとなるため、$cardStrengthを数字の2の強さにする
// それでも同じ数字の場合は引き分け
// 役の判定後、プレイヤー1,プレイヤー2の役および勝者の番号を表示

// 求めるデータ型
// 例）　$player1 = [K,J], $player2 = [10,10]　//showDown()の各要素の2文字目を抽出
// 抽出した文字列をもとにCardの強さを定義したCARD_STRENGTHを参照し、配列を作り直す
// 例）　$player1 = [13,11], $player2 = [10,10]




namespace TwoCardPoker;

const CARD_STRENGTH = [
    'A' => 13,
    2 => 1,
    3 => 2,
    4 => 3,
    5 => 4,
    6 => 5,
    7 => 6,
    8 => 7,
    9 => 8,
    10 => 9,
    'J' => 10,
    'Q' => 11,
    'K' => 12
];

const HIGH_CARD = 'high card';
const PAIR = 'pair';
const STRAIGHT = 'straight';

const STRENGTH_OF_HANDS = [
    'high card' => 1,
    'pair' => 2,
    'straight' => 3
];

const NO_DIFFERENCE = 0;

function convertToStrength(array $playerCards): array
{
    $cardStrength = array_map(fn($playerCard) => CARD_STRENGTH[$playerCard], $playerCards);
    return $cardStrength;
}

function isStraight(int $diff): bool
{
    if ($diff === 1 || isMinMax($diff)) {
        return true;
    }
    return false;
}

function isMinMax(int $diff): bool
{
    return abs($diff) === max(CARD_STRENGTH) - min(CARD_STRENGTH);
}

function isPair(int $diff): bool
{
    if ($diff === NO_DIFFERENCE) {
        return true;
    }
    return false;
}

function judgeTheHand(int $cardStrength1, int $cardStrength2): array
{
    $name = HIGH_CARD;
    $primary = max($cardStrength1, $cardStrength2);
    $secondary = min($cardStrength1, $cardStrength2);
    $diff = ($primary - $secondary);
    if (isStraight($diff)) {
        $name = STRAIGHT;
        if (isMinMax($diff)) {
            $primary = min(CARD_STRENGTH);
            $secondary = max(CARD_STRENGTH);
        }
    }
    if (isPair($diff)) {
        $name = PAIR;
    }
    return [
        'name' => $name,
        'strengthHand' => STRENGTH_OF_HANDS[$name],
        'primary' => $primary,
        'secondary' => $secondary
    ];
}

function decideTheWinner(array $hands1, array $hands2): int
{
    foreach (['strengthHand', 'primary', 'secondary'] as $k) {
        if ($hands1[$k] > $hands2[$k]) {
            return 1;
        }
        if ($hands1[$k] < $hands2[$k]) {
            return 2;
        }
        return 0;
    }
}

function showDown(string ...$cards): array
{
    $playerCards = array_map(fn($card) => substr($card, 1, strlen($card) - 1), $cards);
    $cardStrengths = array_chunk(convertToStrength($playerCards), 2);
    $hands = array_map(fn($cardStrength) => judgeTheHand($cardStrength[0], $cardStrength[1]), $cardStrengths);
    $winner = decideTheWinner($hands[0], $hands[1]);
    return [$hands[0]['name'], $hands[1]['name'], $winner];
}
// メインルーチン
// showDown('CK', 'DA', 'C10', 'H10');
