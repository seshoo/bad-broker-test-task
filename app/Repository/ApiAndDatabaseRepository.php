<?php

namespace App\Repository;

class ApiAndDatabaseRepository implements BaseRepository
{
    private $apiKey;
    private $model;

    public function __construct(string $apiKey, string $model)
    {
        $this->apiKey = $apiKey;
        $this->model = $model;
    }
}
