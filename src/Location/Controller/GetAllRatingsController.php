<?php

namespace App\Location\Controller;

use App\Location\Model\Location;
use App\Rating\Model\Rating;
use App\Rating\Public\RatingCalculator;
use App\Rating\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetAllRatingsController extends AbstractController
{
    public function __construct(
        private readonly RatingRepository $ratingRepository,
    ){
    }

    #[Route('/location/{location}/ratings', name: 'location')]
    public function __invoke(Location $location): Response
    {
        $ratings = $this->ratingRepository->findByLocation($location);

        return $this->json(
            \array_map(
                fn (Rating $rating) => [
                    'id' => $rating->getId(),
                    'score' => $rating->getScore(),
                ],
                $ratings
            )
        );
    }
}
