<?php

namespace App\Services;

use App\Services\Entries\Rate;
use App\Services\Entries\Trade;

class Revenue
{
    public static function get(array $rates = [], \DateTime $from, \DateTime $to, float $amount, float $brokerFeeOnDay)
    {
        $currency = null;
        $buyDate = null;
        $sellDate = null;
        $maxRevenue = 0;

        foreach ($rates as $code => $data) {
            for ($i = 0; $i < count($data) - 1; $i++) {
                for ($j = $i + 1; $j < count($data); $j++) {
                    $revenue = static::calculate($data[$i], $data[$j], $amount, $brokerFeeOnDay);
                    if ($revenue > $maxRevenue) {
                        $maxRevenue = $revenue;
                        $currency = $code;
                        $buyDate = $data[$i]->getDate();
                        $sellDate = $data[$j]->getDate();;
                    }
                }
            }
        }
        return new Trade($currency, $buyDate, $sellDate, $maxRevenue);
    }

    public static function calculate(Rate $buy, Rate $sell, float $amount, float $feeOnDay): float
    {
        $days = ($sell->getDate()->getTimestamp() - $buy->getDate()->getTimestamp()) / 86400;

        return ($buy->getPrice() *  $amount / $sell->getPrice()) - $days * $feeOnDay;
    }
}
