<?php

namespace App\Repository;

interface BaseRepository
{
    public function getDataByPeriod(\DateTime $from, \DateTime $to);
}
