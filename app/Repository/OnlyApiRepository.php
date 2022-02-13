<?php

namespace App\Repository;

use App\Services\Tools\BaseClient;

class OnlyApiRepository implements BaseRepository
{
    private $client;

    public function __construct(BaseClient $client)
    {
        $this->client = $client;
    }

    public function getDataByPeriod(\DateTime $from, \DateTime $to)
    {
        $result = [];
        $iterator = clone $from;
        while ($iterator->getTimestamp() <= $to->getTimestamp()) {

            $result = array_merge(
                $result,
                $this->client->get($iterator)
            );
            $iterator->modify('+1 day');
        }

        $result = static::groupByField($result, 'currency');

        return $result;
    }

    protected static function groupByField(array $input, string $field)
    {
        $output = [];
        foreach ($input as $val) {
            $output[$val->$field][] = $val;
        }

        return $output;
    }
}
