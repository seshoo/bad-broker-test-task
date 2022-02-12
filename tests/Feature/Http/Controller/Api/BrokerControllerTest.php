<?php

namespace Tests\Feature\Http\Controller\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class BrokerControllerTest extends TestCase
{
    use WithFaker;

    const DATE_FORMAT = 'Y-m-d';

    /**
     * @test
     *
     * @return void
     */
    public function can_get_maximum_revenue()
    {
        $endDate = $this->faker->dateTimeBetween('-1 month', '+0 day')->format(static::DATE_FORMAT);
        $startDate =  $this->faker->dateTimeBetween('-1 month', $endDate)->format(static::DATE_FORMAT);
        $amount =  $this->faker->numberBetween(1, 100);

        $response = $this->json(
            Request::METHOD_POST,
            '/api/get_maximum_revenue',
            [
                'endDate' => $endDate,
                'startDate' => $startDate,
                'amount' => $amount,
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
    }
}
