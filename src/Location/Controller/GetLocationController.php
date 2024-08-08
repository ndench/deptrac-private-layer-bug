<?php

namespace App\Location\Controller;

use App\Location\Model\Location;
use App\Rating\Public\RatingCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetLocationController extends AbstractController
{
    public function __construct(
        private readonly RatingCalculator $ratingCalculator,
    ){
    }

    #[Route('/location/{location}', name: 'location')]
    public function __invoke(Location $location): Response
    {
        $rating = $this->ratingCalculator->getAverageRating($location);

        return $this->json([
            'id' => $location->getId(),
            'name' => $location->getName(),
            'rating' => $rating,
        ]);
    }
}
