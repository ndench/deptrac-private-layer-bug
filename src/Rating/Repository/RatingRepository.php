<?php

namespace App\Rating\Repository;

use App\Location\Public\LocationInterface;
use App\Rating\Model\Rating;

class RatingRepository
{
    /** @var list<Rating> */
    private array $ratings = [];

    public function addRating(Rating $rating): void
    {
        $this->ratings[] = $rating;
    }

    /**
     * @return Rating[]
     */
    public function findByLocation(LocationInterface $location): array
    {
        return \array_filter(
            $this->ratings,
            fn (Rating $rating) => $rating->getLocation()->getId() === $location->getId()
        );
    }
}
