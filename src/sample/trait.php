<?php

trait TaxCalculator
{
  private float $tax = 0.1;
  private int $price;

  public function taxedPrice()
  {
    return $this->price * (1 + $this->tax);
  }
}

trait AmericanTaxCalculator
{
  private int $price;

  public function taxedPrice()
  {
    return $this->price;
  }
}

class Book
{
  use TaxCalculator, AmericanTaxCalculator {
    AmericanTaxCalculator::taxedPrice insteadof TaxCalculator;
  }

  private int $price;

  public function __construct(private string $title, int $price)
  {
    $this->price = $price;
  }
}

class Drink
{
  use TaxCalculator;

  private int $price;

  public function __construct(private string $title, int $price)
  {
    $this->price = $price;
  }
}

$book = new Book('ハリー・ポッター', 1000);
echo $book->taxedPrice() . PHP_EOL; //1000
$drink = new Drink('コーラ', 100);
echo $drink->taxedPrice() . PHP_EOL; // 110
