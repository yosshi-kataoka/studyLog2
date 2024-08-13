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
const STRENGTH_OF_HANDS = [
    'high card' => 1,
    'pair' => 2,
    'straight' => 3
];

function convertToStrength(array $playerCards): array
{
    $playerCard = [];
    foreach ($playerCards as $cardNumber) {
        $playerCard[] = CARD_STRENGTH[$cardNumber];
    }
    return $playerCard;
}

function isStraight(int $diff): bool
{
    if ($diff === 1 || $diff === 12) {
        return true;
    }
    return false;
}

function isPair(int $diff): bool
{
    if ($diff === 0) {
        return true;
    }
    return false;
}

function judgeTheHand(array $hand): array
{
    $playerHand = 'high card';
    $maxHandStrength = max($hand);
    $minHandStrength = min($hand);
    $diff = ((int)$maxHandStrength - (int)$minHandStrength);
    if (isStraight($diff)) {
        $playerHand = 'straight';
        if ($diff === 12) {
            $maxHandStrength = $minHandStrength;
        }
    }
    if (isPair($diff)) {
        $playerHand = 'pair';
    }
    return [$playerHand, $maxHandStrength];
}

function decideTheWinner(array $hands): int
{
    $handStrength = [];
    $cardStrength = [];
    foreach ($hands as $hand) {
        $handStrength[] = STRENGTH_OF_HANDS[$hand[0]];
        $cardStrength[] = $hand[1];
    }
    $victoryOrDefeat = ($handStrength[0] > $handStrength[1]) ? 1 : (($handStrength[0] < $handStrength[1]) ? 2 : 0);
    if ($victoryOrDefeat === 0) {
        $victoryOrDefeat = ($cardStrength[0] > $cardStrength[1]) ? 1 : (($cardStrength[0] < $cardStrength[1]) ? 2 : 0);
    }
    return $victoryOrDefeat;
}

function display(array $hands, int $victoryOrDefeat): string
{
    $playerHands = [];
    foreach ($hands as $hand) {
        $playerHands[] = $hand[0];
    }
    return implode(',', $playerHands) . ',' . $victoryOrDefeat . PHP_EOL;
}

function showDown(string $player1Card1, string $player1Card2, string $player2Card1, string $player2Card2): void
{
    $cards = [$player1Card1, $player1Card2, $player2Card1, $player2Card2];
    $playerCards = [];
    foreach ($cards as $card) {
        $playerCards[] = substr($card, 1);
    }
    $playerCardsStrength = array_chunk(convertToStrength($playerCards), 2);
    $hands = [];
    $hands[] = array_map(fn($playerCardStrength) => judgeTheHand($playerCardStrength), $playerCardsStrength);
    $victoryOrDefeat = decideTheWinner($hands[0]);
    echo display($hands[0], $victoryOrDefeat);
}
// メインルーチン
showDown('CK', 'DJ', 'C10', 'H10');
