<?php

declare(strict_types=1);

namespace App\Controller\Api\Garage;

use App\Persistence\Repository\GarageAppRepository;
use App\Toolbox\Trait\Controller\ApiController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'api/garage',
    name: 'api.garage.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class AppController extends AbstractController
{
    use ApiController;

    #[Route(path: '/index', name: 'index')]
    public function index(GarageAppRepository $repository): JsonResponse
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
