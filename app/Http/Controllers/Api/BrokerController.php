<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrokerFormRequest;
use App\Repository\OnlyApiRepository;
use App\Services\DataManager;
use App\Services\Tools\FakeClient;
use App\Services\Revenue;
use DateTime;

class BrokerController extends Controller
{
    function getMaximumRevenue(BrokerFormRequest $request)
    {

        $data = $request->validated();

        $apiKey = \config('exchangeratesapi.key');
        $baseCurrency = \config('exchangeratesapi.base_currency');
        $currencies = \config('exchangeratesapi.currencies');
        $currencies = \config('exchangeratesapi.currencies');
        $brokerFee = \config('broker.fee');

        $client = new FakeClient($apiKey, $baseCurrency, $currencies);
        $repository = new OnlyApiRepository($client);
        $dataManager = new DataManager($repository);

        $dataByPeriod = $dataManager->getDataByPeriod(
            new DateTime($data['startDate']),
            new DateTime($data['endDate'])
        );

        $bestTrade = Revenue::get(
            $dataByPeriod,
            new DateTime($data['startDate']),
            new DateTime($data['endDate']),
            $data['amount'],
            $brokerFee
        );
        return [
            'date' => $dataByPeriod,
            'best_trade' => $bestTrade->getMessage()
        ];
    }
}
