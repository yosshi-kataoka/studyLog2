<?php

class Player
{
  public function __construct(private string $name) {}

  public function drawCards()
  {
    $cards = $this->prepareCards();
    $cards = $this->shuffleCards($cards);
    return $this->selectCards($cards);
  }

  private function prepareCards()
  {
    // TODO:仮実装 //=>ハート（H1~H13)、スペード（S1~S13)、クラブ（C1~C13)、ダイア（D1~D13)の合計52枚のカードを作成する
    return 52;
  }

  private function shuffleCards($cards)
  {
    // TODO:仮実装　//=>52枚のカードをシャッフルして返す
    return $cards;
  }

  private function  selectCards($cards)
  {
    // TODO:仮実装　//=>シャッフルされた52枚のカードより2枚を返す
    return ['H2', 'H3'];
  }
}
