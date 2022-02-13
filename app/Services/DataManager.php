<?php

namespace App\Services;

use App\Repository\BaseRepository;

class DataManager
{
    public $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getDataByPeriod(\DateTime $from, \DateTime $to)
    {
        return $this->repository->getDataByPeriod($from, $to);
    }
}
