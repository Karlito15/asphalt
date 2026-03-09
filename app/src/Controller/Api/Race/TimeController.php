<?php

declare(strict_types=1);

namespace App\Controller\Api\Race;

use App\Persistence\Repository\RaceTimeRepository;
use App\Toolbox\Trait\Controller\ApiController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/api/race/time',
    name: 'api.race.time.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class TimeController extends AbstractController
{
    use ApiController;

    #[Route(path: '/index', name: 'index')]
    public function index(RaceTimeRepository $repository): JsonResponse
    {
        return $this->json(
            $repository->findAll(),
            Response::HTTP_OK,
            self::getHeaders(),
            self::getContext([
                'groups' => ['api'],
            ])
        );
    }
}
