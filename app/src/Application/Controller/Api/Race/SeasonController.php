<?php

declare(strict_types=1);

namespace App\Application\Controller\Api\Race;

use App\Application\Service\Controller\ApiController;
use App\Domain\Repository\RaceSeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'api/race/season',
    name: 'api.race.season.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class SeasonController extends AbstractController
{
    use ApiController;

    #[Route(path: '/index', name: 'index')]
    public function index(RaceSeasonRepository $repository): JsonResponse
    {
        return $this->json(
            $repository->findAll(),
            Response::HTTP_OK,
            self::getHeaders(),
            self::getContext([
                'groups' => ['index'],
            ])
        );
    }
}
