<?php

namespace App\Rating\Model;

use App\Location\Public\LocationInterface;

readonly class Rating
{
    public function __construct(
        private string $id,
        private LocationInterface $location,
        private int $score,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocation(): LocationInterface
    {
        return $this->location;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
