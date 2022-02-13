<?php

namespace App\Services\Tools;

interface BaseClient
{
    public function __construct(string $apiKey, string $baseCurrency, array $currencies);
    public function get(\DateTime $date);
}
