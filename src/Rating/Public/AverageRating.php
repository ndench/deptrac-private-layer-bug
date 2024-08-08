<?php

namespace App\Rating\Public;

use App\Location\Public\LocationInterface;

readonly class AverageRating
{
    public function __construct(
        public LocationInterface $location,
        public float $averageRating,
    ) {}
}
