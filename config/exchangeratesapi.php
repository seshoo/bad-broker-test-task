<?php

return [
    'key' =>  env('EXCHANGERATES_API_KEY', ''),
    'base_currency' => 'EUR',
    'currencies' =>  [
        'RUB',
        'USD',
        'GBP',
        'JPY'
    ],
];
