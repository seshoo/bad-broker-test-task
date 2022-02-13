<?php

namespace App\Services\Entries;

class Rate
{
    public $baseCurrency;
    public $currency;
    public $date;
    public $price;

    public function __construct(string $baseCurrency, string $currency, \DateTime $date, float $price)
    {
        $this->baseCurrency = $baseCurrency;
        $this->currency = $currency;
        $this->date = $date;
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDate()
    {
        return $this->date;
    }
}
