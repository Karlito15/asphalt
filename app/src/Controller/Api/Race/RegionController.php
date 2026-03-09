<?php

declare(strict_types=1);

namespace App\Controller\Api\Race;

use App\Persistence\Repository\RaceRegionRepository;
use App\Toolbox\Trait\Controller\ApiController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/api/race/region',
    name: 'api.race.region.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class RegionController extends AbstractController
{
    use ApiController;

    #[Route(path: '/index', name: 'index')]
    public function index(RaceRegionRepository $repository): JsonResponse
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
