<?php

namespace ConvertToNumber;

function ConvertToNumber(string  ...$cards): array
{
    // アロー関数使用の場合
    $result = array_map(fn($card) => substr($card, 1, strlen($card) - 1), $cards);
    return $result;
    // 無名関数使用の場合
    // $result = array_map(function ($card) {
    //     return substr($card, 1, strlen($card) - 1);
    // }, $cards);
}
