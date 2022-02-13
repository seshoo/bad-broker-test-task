<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\BrokerFormRequest;
use Faker\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class BrokerFormRequestTest extends TestCase
{
    const DATE_FORMAT = 'Y-m-d';
    const DIFFERENT_DAYS = 60;

    const WRONG_DATE_FORMATS = [
        "d-m-Y",
        'm-d-Y',
        'd.m.Y',
        'd.M.Y',
        'Y-m-d',
        'm.d.Y',
    ];


    public function setUp(): void
    {
        parent::setUp();
        $this->rules = (new BrokerFormRequest())->rules();
    }

    /**
     *  @test
     * */
    public function it_should_be_available_for_non_authorized_user()
    {
        $request = new BrokerFormRequest();

        $this->assertTrue($request->authorize());
    }

    public function validationProvider()
    {
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        // on the off-chance
        $wrongFormats = array_diff(static::WRONG_DATE_FORMATS, [static::DATE_FORMAT]);
        $dataSets = [];

        $endDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $startDate =  $faker->dateTimeBetween(
            (clone $endDate)->modify('-' . static::DIFFERENT_DAYS . ' days'),
            $endDate
        );
        $dataSets['request should pass when data is provided'] = [
            'passed' => true,
            'data' => [
                'startDate' => $startDate->format(static::DATE_FORMAT),
                'endDate' => $endDate->format(static::DATE_FORMAT),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $endDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $dataSets['request should fail when start date missing'] = [
            'passed' => false,
            'data' => [
                'endDate' => $endDate->format(static::DATE_FORMAT),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $startDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $dataSets['request should fail when end date missing'] = [
            'passed' => false,
            'data' => [
                'startDate' => $endDate->format(static::DATE_FORMAT),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $endDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $dataSets['request should fail when start date has wrong type'] = [
            'passed' => false,
            'data' => [
                'startDate' => $faker->word(),
                'endDate' => $endDate->format(static::DATE_FORMAT),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $startDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $dataSets['request should fail when end date has wrong type'] = [
            'passed' => false,
            'data' => [
                'startDate' =>  $startDate->format(static::DATE_FORMAT),
                'endDate' => $faker->word(),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $endDate = $faker->dateTimeBetween('+0 day', '+1 week');
        $startDate =  $faker->dateTimeBetween('-1 week', $endDate);
        $dataSets['request should fail when end date is greater than current'] = [
            'passed' => false,
            'data' => [
                'startDate' => $startDate->format(static::DATE_FORMAT),
                'endDate' => $endDate->format(static::DATE_FORMAT),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $endDate = $faker->dateTimeBetween('-1 year', '-1 week');
        $startDate =  $faker->dateTimeBetween($endDate, '-1 day');
        $dataSets['request should fail when start date is greater than end date'] = [
            'passed' => false,
            'data' => [
                'startDate' => $startDate->format(static::DATE_FORMAT),
                'endDate' => $endDate->format(static::DATE_FORMAT),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $endDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $startDate =  $faker->dateTimeBetween(
            (clone $endDate)->modify('-' . static::DIFFERENT_DAYS . ' days'),
            $endDate
        );
        $dataSets['request should fail when start data has wrong format'] = [
            'passed' => false,
            'data' => [
                'startDate' => $startDate->format($faker->randomElement($wrongFormats)),
                'endDate' => $endDate->format(static::DATE_FORMAT),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $endDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $startDate =  $faker->dateTimeBetween(
            (clone $endDate)->modify('-' . static::DIFFERENT_DAYS . ' days'),
            $endDate
        );
        $dataSets['request should fail when end data has wrong format'] = [
            'passed' => false,
            'data' => [
                'startDate' => $startDate->format(static::DATE_FORMAT),
                'endDate' => $endDate->format($faker->randomElement($wrongFormats)),
                'amount' => $faker->numberBetween(1, 100),
            ]
        ];

        $endDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $startDate =  $faker->dateTimeBetween(
            (clone $endDate)->modify('-' . static::DIFFERENT_DAYS . ' days'),
            $endDate
        );
        $dataSets['request should fail when amount missing'] = [
            'passed' => false,
            'data' => [
                'startDate' => $startDate->format(static::DATE_FORMAT),
                'endDate' => $endDate->format(static::DATE_FORMAT),
            ]
        ];

        $endDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $startDate =  $faker->dateTimeBetween(
            (clone $endDate)->modify('-' . static::DIFFERENT_DAYS . ' days'),
            $endDate
        );
        $dataSets['request should fail when amount is not numeral'] = [
            'passed' => false,
            'data' => [
                'startDate' => $startDate->format(static::DATE_FORMAT),
                'endDate' => $endDate->format(static::DATE_FORMAT),
                'amount' => $faker->word(),
            ]
        ];

        $endDate = $faker->dateTimeBetween('-1 year', '+0 day');
        $startDate =  $faker->dateTimeBetween(
            (clone $endDate)->modify('-' . static::DIFFERENT_DAYS . ' days'),
            $endDate
        );
        $dataSets['request should fail when amount less zero'] = [
            'passed' => false,
            'data' => [
                'startDate' => $startDate->format(static::DATE_FORMAT),
                'endDate' => $endDate->format(static::DATE_FORMAT),
                'amount' =>  $faker->numberBetween(-50, -1),
            ]
        ];
        return $dataSets;
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function validation_results_as_expected($shouldPass, $mockedRequestData)
    {
        $validator = Validator::make($mockedRequestData, $this->rules);

        $this->assertEquals(
            $shouldPass,
            $validator->passes()
        );
    }
}
