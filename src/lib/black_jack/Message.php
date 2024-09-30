<?php

namespace BlackJack;

class Message
{
  public function startMessage(): void
  {
    echo 'ブラックジャックを開始します。' . PHP_EOL;
  }

  public function getCardMessage($drawnCard): void
  {
    echo 'あなたの引いたカードは' . $drawnCard['suit'] . 'の' . $drawnCard['number'] . 'です.' . PHP_EOL;
  }
}
