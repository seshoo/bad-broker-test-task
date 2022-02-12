<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrokerFormRequest;

class BrokerController extends Controller
{
    function getMaximumRevenue(BrokerFormRequest $request)
    {
        $data = $request->validated();

        return  $data;
    }
}
