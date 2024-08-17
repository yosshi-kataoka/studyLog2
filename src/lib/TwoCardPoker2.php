<?php

namespace TwoCardPoker2;

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
const HANDS_STRENGTH = [
    'high card' => 1,
    'pair' => 2,
    'straight' => 3,
];


function showDown(string ...$inputs): array
{
    $inputData = deleteFirstLetter($inputs);
    $playerCards = convertToRank($inputData);
    $playerCard = array_chunk($playerCards, 2);
    $hands = array_map(fn($hand) => judgeTheHand($hand), $playerCard);
    $winner = decideTheWinner($hands);
    return [$hands[0]['name'], $hands[1]['name'], $winner];
    // 'CK', 'DJ', 'C3', 'H4' //=>[K.J,3,4]に分ける
    // 強さに変換//=> ([11,9,1,2])
    // 配列を要素２つずつに区切る//=>([11,9],[1,2])
    // 役の判定 //=>[役名、役の強さ,maxカードrank,minカードrank]
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

function isMinMax(int $card1, int $card2): bool
{
    if ((abs($card1 - $card2) === 12)) {
        return true;
    }
    return false;
}

function isStraight(int $card1, int $card2): bool
{
    if (($card1 - $card2) === 1 || isMinMax($card1, $card2)) {
        return true;
    }
    return false;
}

function isPair(int $card1, int $card2): bool
{
    if (($card1 - $card2) === 0) {
        return true;
    }
    return false;
}

function JudgeTheHand(array $playerCard,): array
{
    $name = HIGH_CARD;
    $primary = max($playerCard);
    $secondary = min($playerCard);
    if (isStraight($primary, $secondary)) {
        $name = STRAIGHT;
        if (isMinMax($primary, $secondary)) {
            $primary = min($playerCard);
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
        'secondary' => $secondary
    ];
}

function decideTheWinner(array $hands): int
{
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
