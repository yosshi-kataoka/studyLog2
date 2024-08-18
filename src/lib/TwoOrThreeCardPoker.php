<?php

// 各プレイヤーに配られたカードの枚数が2枚ずつのときはツーカードポーカーとして処理し、配られたカードの枚数が3枚ずつのときはスリーカードポーカーとして処理します。

// ◯お題
// - プレイヤーは2人です
// - 各プレイヤーはトランプ2枚もしくは3枚を与えられます
// - ジョーカーはありません
// - 与えられたカードから、役を判定します。役は番号が大きくなるほど強くなります
// - - トランプ2枚のとき --
// 1. ハイカード：以下の役が一つも成立していない
// 2. ペア：2枚のカードが同じ数字
// 3. ストレート：2枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2 と K-A の2つです・2つの手札について、強さは以下に従います
// 4. 2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
// 5. 2つの手札の役が同じ場合、各カードの数値によって強さを比較する ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強) ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、もう一枚のカード同士を比較する ・ペア：ペアの数字を比較する ・ストレート：一番強い数字を比較する (ただし、A-2 の組み合わせの場合、2 を一番強い数字とする。K-A が最強、A-2 が最弱) ・数値が同じ場合：引き分け
// - - トランプ3枚のとき --
// 1. ハイカード：以下の役が一つも成立していない
// 2. ペア：2枚のカードが同じ数字
// 3. ストレート：3枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2-3 と Q-K-A の2つ。ただし、K-A-2 のランクの組み合わせはストレートとはみなさない
// 4. スリーカード：3枚のカードが同じ数字・2つの手札について、強さは以下に従います
// 5. 2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
// 6. 2つの手札の役が同じ場合、各カードの数値によって強さを比較する ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強) ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、二番目に強いカード同士を比較する。左記が同じ数字の場合、三番目に強いランクを持つカード同士を比較する。左記が同じランクの場合は引き分け ・ペア：ペアの数字を比較する。左記が同じランクの場合、ペアではない3枚目同士のランクを比較する。左記が同じランクの場合は引き分け ・ストレート：一番強い数字を比較する (ただし、A-2-3 の組み合わせの場合、3 を一番強い数字とする。Q-K-A が最強、A-2-3 が最弱)。一番強いランクが同じ場合は引き分け ・スリーカード：スリーカードの数字を比較する。スリーカードのランクが同じ場合は引き分け

// ◯仕様
// - それぞれの役と勝敗を判定するshowResultメソッドを定義してください。
// - showResultメソッドは引数として、プレイヤー1のカードの配列、プレイヤー2のカードの配列を取ります。
// - カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。ただし、Jは11、Qは12、Kは13、Aは1とします。
// - showResultメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。

namespace TwoOrThreeCardPoker;

const CARD_NUMBER = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K', 'A'];

define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARD_NUMBER as $key => $index) {
        $cardRanks[$index] = $key;
    }
    return $cardRanks;
})());

const USE_CARD_NUMBER_IS_TWO = 2;
const USE_CARD_NUMBER_IS_THREE = 3;


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



function showResult(array ...$inputs): array
{
    $inputsData = array_map(fn($input) => deleteFirstLetter($input), $inputs);
    $playerCardRanks = array_map(fn($inputData) => convertToRank($inputData), $inputsData);
    $playerCard = splitTheArray($playerCardRanks);
    $hands = array_map(fn($hand) => judgeTheHand($hand), $playerCard[0]);
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

function splitTheArray(array $playerCardRanks): array
{

    if (count($playerCardRanks) === USE_CARD_NUMBER_IS_TWO) {
        return array_chunk($playerCardRanks, USE_CARD_NUMBER_IS_TWO);
    }
    return array_chunk($playerCardRanks, USE_CARD_NUMBER_IS_THREE);
}

function isThree(int $card1, int $card2, int $card3): bool
{
    if ($card1 === $card2 && $card2 === $card3) {
        return true;
    }
    return false;
}

function isMinMax(int ...$cards): bool
{
    if (count($cards) === USE_CARD_NUMBER_IS_THREE) {
        if ((abs($cards[0] - $cards[2]) === 12 && ($cards[2] + 1) === $cards[1])) {
            return true;
        }
    }
    if (($cards[0] - $cards[1]) === 12) {
        return true;
    }
    return false;
}

function isStraight(int ...$cards): bool
{
    if (count($cards) === USE_CARD_NUMBER_IS_THREE) {
        if (($cards[2] + 1) === $cards[1] || isMinMax($cards[0], $cards[1], $cards[2])) {
            return true;
        }
    }
    if (count($cards) === USE_CARD_NUMBER_IS_TWO) {
        if (($cards[0] - $cards[1]) === 1 || isMinMax($cards[0], $cards[1])) {
            return true;
        }
    }
    return false;
}

function isPair(int ...$cards): bool
{
    $result = array_count_values($cards);
    if (in_array(2, $result)) {
        return true;
    }
    return false;
}

function JudgeTheHand(array $playerCard): array
{
    $name = HIGH_CARD;
    rsort($playerCard);
    $primary = $playerCard[0];
    $secondary = $playerCard[1];
    if (count($playerCard) === USE_CARD_NUMBER_IS_THREE) {
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
    } elseif (count($playerCard) === USE_CARD_NUMBER_IS_TWO) {
        if (isStraight($primary, $secondary)) {
            $name = STRAIGHT;
            if (isMinMax($primary, $secondary)) {
                $primary = $secondary;
                $secondary = max($playerCard);
            }
        }
        if (isPair($primary, $secondary)) {
            $name = PAIR;
        }
        $handRank = HANDS_STRENGTH[$name];
        return [
            'name' => $name,
            'handRank' => $handRank,
            'primary' => $primary,
            'secondary' => $secondary,
        ];
    }
}

function decideTheWinner(array $hands): int
{
    if (array_key_exists('tertiary', $hands[0])) {
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
    foreach (['handRank', 'primary', 'secondary'] as $k) {
        if ($hands[0][$k] > ($hands[1][$k])) {
            return 1;
        }
        if ($hands[0][$k] < ($hands[1][$k])) {
            return 2;
        }
    }
    return 0;
}
