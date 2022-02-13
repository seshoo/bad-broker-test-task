<?php

namespace App\Services\Tools;

use App\Services\Entries\Rate;
use Faker\Factory;

class FakeClient implements BaseClient
{
    private $baseCurrency;
    private $currencies;

    public function __construct(string $apiKey, string $baseCurrency, array $currencies)
    {
        $this->baseCurrency = $baseCurrency;
        $this->currencies = $currencies;
    }

    public function get(\DateTime $date)
    {
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        $result = [];
        foreach ($this->currencies as $currency) {
            $result[] = new Rate(
                $this->baseCurrency,
                $currency,
                clone $date,
                $faker->randomFloat(6, 10, 100)
            );
        }

        return $result;
    }
}
