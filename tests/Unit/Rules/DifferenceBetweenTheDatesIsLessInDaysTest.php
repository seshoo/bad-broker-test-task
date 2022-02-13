<?php

namespace Tests\Unit\Rules;

use App\Rules\DifferenceBetweenTheDatesIsLessInDays;
use Faker\Factory;
use Tests\TestCase;

class DifferenceBetweenTheDatesIsLessInDaysTest extends TestCase
{
    const DATE_FORMAT = 'Y-m-d';

    const FIRST = 'first_date';
    const SECOND = 'second_date';

    public function validationProvider()
    {
        $dataSets = [];
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        $count = $faker->numberBetween(1, 100);
        $first = $faker->dateTimeBetween('-1 year', '+0 day');
        $second = (clone  $first)->modify('+' . $faker->numberBetween(1, $count) . ' days');
        $dataSets['request should pass when different is less and second date is greater than first date'] = [
            'passed' => true,
            'data' => [
                static::FIRST => $first->format(static::DATE_FORMAT),
                static::SECOND => $second->format(static::DATE_FORMAT),
            ],
            'days' => $count
        ];

        $count = $faker->numberBetween(1, 100);
        $first = $faker->dateTimeBetween('-1 year', '+0 day');
        $second = (clone  $first)->modify('-' . $faker->numberBetween(1, $count) . ' days');
        $dataSets['request should pass when different is less and second date is less than first date'] = [
            'passed' => true,
            'data' => [
                static::FIRST => $first->format(static::DATE_FORMAT),
                static::SECOND => $second->format(static::DATE_FORMAT),
            ],
            'days' => $count
        ];

        $count = $faker->numberBetween(1, 100);
        $first = $faker->dateTimeBetween('-1 year', '+0 day');
        $second = (clone  $first)->modify('+' . $faker->numberBetween($count + 1, $count + 100) . ' days');
        $dataSets['request should fail when different is greater and second date is greater than first date'] = [
            'passed' => false,
            'data' => [
                static::FIRST => $first->format(static::DATE_FORMAT),
                static::SECOND => $second->format(static::DATE_FORMAT),
            ],
            'days' => $count
        ];

        $count = $faker->numberBetween(1, 100);
        $first = $faker->dateTimeBetween('-1 year', '+0 day');
        $second = (clone  $first)->modify('-' . $faker->numberBetween($count + 1, $count + 100) . ' days');
        $dataSets['request should fail when different is greater and second date is less than first date'] = [
            'passed' => false,
            'data' => [
                static::FIRST => $first->format(static::DATE_FORMAT),
                static::SECOND => $second->format(static::DATE_FORMAT),
            ],
            'days' => $count
        ];

        $count = $faker->numberBetween(1, 100);
        $first = $faker->dateTimeBetween('-1 year', '+0 day');
        $dataSets['request should pass when different is zero'] = [
            'passed' => true,
            'data' => [
                static::FIRST => $first->format(static::DATE_FORMAT),
                static::SECOND => $first->format(static::DATE_FORMAT),
            ],
            'days' => $count
        ];

        return $dataSets;
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function validation_results_as_expected($shouldPass, $mockedRequestData, $days)
    {
        $rule = new DifferenceBetweenTheDatesIsLessInDays(static::SECOND, $days);
        $rule->setData($mockedRequestData);

        $this->assertEquals(
            $shouldPass,
            $rule->passes(
                static::FIRST,
                $mockedRequestData[static::FIRST]
            )
        );
    }
}
