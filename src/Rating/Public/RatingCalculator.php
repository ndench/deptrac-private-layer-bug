<?php

namespace App\Rating\Public;

use App\Location\Public\LocationInterface;
use App\Rating\Repository\RatingRepository;

readonly class RatingCalculator
{
    public function __construct(
        private RatingRepository $ratingRepository,
    ) {
    }

    public function getAverageRating(LocationInterface $location): AverageRating
    {
        $ratings = $this->ratingRepository->findByLocation($location);
        $scores  = \array_map(fn($rating) => $rating->getScore(), $ratings);

        if (\count($scores) === 0) {
            return new AverageRating($location, 0);
        }

        return new AverageRating($location, \array_sum($scores) / \count($ratings));
    }
}
