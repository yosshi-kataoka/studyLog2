<?php

// ◯お題
// 「ツーカードポーカー」に「カードの枚数を3枚に変更して」と仕様変更が発生しました。
// ・ツーカードポーカーのファイルをコピーして新規ファイルを作成しましょう
// ・カード枚数を3枚に変更しましょう
// ・役の仕様は下記に変更します。役は番号が大きくなるほど強くなります
// ハイカード：以下の役が一つも成立していない
// ペア：2枚のカードが同じ数字
// ストレート：3枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2-3 と Q-K-A の2つ。ただし、K-A-2 のランクの組み合わせはストレートとはみなさない
// スリーカード：3枚のカードが同じ数字
// ・2つの手札について、強さは以下に従います
// 2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
// 2つの手札の役が同じ場合、各カードの数値によって強さを比較する
// 　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
// 　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、二番目に強いカード同士を比較する。左記が同じ数字の場合、三番目に強いランクを持つカード同士を比較する。左記が同じランクの場合は引き分け
// 　 ・ペア：ペアの数字を比較する。左記が同じランクの場合、ペアではない3枚目同士のランクを比較する。左記が同じランクの場合は引き分け
// 　 ・ストレート：一番強い数字を比較する (ただし、A-2-3 の組み合わせの場合、3 を一番強い数字とする。Q-K-A が最強、A-2-3 が最弱)。一番強いランクが同じ場合は引き分け
// 　 ・スリーカード：スリーカードの数字を比較する。スリーカードのランクが同じ場合は引き分け
// それぞれの役と勝敗を判定するプログラムを作成ください。

// ◯仕様
// それぞれの役と勝敗を判定するshowメソッドを定義してください。
// showメソッドは引数として、プレイヤー1のカード、プレイヤー1のカード、プレイヤー1のカード、プレイヤー2のカード、プレイヤー2のカード、プレイヤー2のカードを取ります。
// カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。ただし、Jは11、Qは12、Kは13、Aは1とします。
// showメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。

namespace TwoCardPoker3;

const CARD_NUMBER = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K', 'A'];

define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARD_NUMBER as $key => $index) {
        $cardRanks[$index] = $key;
    }
    return $cardRanks;
})());

const HIGH_CARD = 'high card';
const PAIR = 'pair';
const STRAIGHT = 'straight';
const THREE_CARD = 'three card';

const HANDS_STRENGTH = [
    'high card' => 1,
    'pair' => 2,
    'straight' => 3,
    'three card' => 4,
];


function show(string ...$inputs): array
{
    $inputData = deleteFirstLetter($inputs);
    $playerCards = convertToRank($inputData);
    $playerCard = array_chunk($playerCards, 3);
    $hands = array_map(fn($hand) => judgeTheHand($hand), $playerCard);
    $winner = decideTheWinner($hands);
    return [$hands[0]['name'], $hands[1]['name'], $winner];
    // 'CK', 'DJ', ,'H9', 'C10', 'H10', 'D3' //=>[K.J,9,10,10,3]に分ける
    // 強さに変換//=> ([11,9,7,8,8,1])
    // 配列を要素２つずつに区切る//=>([11,9],[7,8],[8,1])
    // 役の判定 //=>[役名、役の強さ,maxカードrank,2番目に強いカードrank,minカードrank]
    // 勝者の判定 //=>0,1,2を返す
    // 結果を表示 //=>[プレイやー1の役名,プレイやー2の役名,勝者(0,1,2のいずれか)]
}

function deleteFirstLetter(array $playerCards): array
{
    $result = array_map(fn($playerCard) => substr($playerCard, 1, strlen($playerCard) - 1), $playerCards);
    return $result;
}

function convertToRank(array $inputData): array
{
    $playerCardRanks = array_map(fn($playerCardRank) => CARD_RANK[$playerCardRank], $inputData);
    return $playerCardRanks;
}

function isThree(int $card1, int $card2, int $card3): bool
{
    if ($card1 === $card2 && $card2 === $card3) {
        return true;
    }
    return false;
}

function isMinMax(int $card1, int $card2, int $card3): bool
{
    if ((abs($card1 - $card3) === 12 && ($card3 + 1) === $card2)) {
        return true;
    }
    return false;
}

function isStraight(int $card1, int $card2, int $card3): bool
{
    if (($card3 + 1) === $card2 || isMinMax($card1, $card2, $card3)) {
        return true;
    }
    return false;
}

function isPair(int ...$cards)
{
    $result = array_count_values($cards);
    if (in_array(2, $result)) {
        return true;
    }
    return false;
}

function JudgeTheHand(array $playerCard,): array
{
    $name = HIGH_CARD;
    rsort($playerCard);
    $primary = $playerCard[0];
    $secondary = $playerCard[1];
    $tertiary  = $playerCard[2];
    if (isThree($primary, $secondary, $tertiary)) {
        $name = THREE_CARD;
    }
    if (isStraight($primary, $secondary, $tertiary)) {
        $name = STRAIGHT;
        if (isMinMax($primary, $secondary, $tertiary)) {
            $primary = $secondary;
            $secondary = max($playerCard);
        }
    }
    if (isPair($primary, $secondary, $tertiary)) {
        $name = PAIR;
    }
    $handRank = HANDS_STRENGTH[$name];
    return [
        'name' => $name,
        'handRank' => $handRank,
        'primary' => $primary,
        'secondary' => $secondary,
        'tertiary' => $tertiary
    ];
}

function decideTheWinner(array $hands): int
{
    foreach (['handRank', 'primary', 'secondary', 'tertiary'] as $k) {
        if ($hands[0][$k] > ($hands[1][$k])) {
            return 1;
        }
        if ($hands[0][$k] < ($hands[1][$k])) {
            return 2;
        }
    }
    return 0;
}
