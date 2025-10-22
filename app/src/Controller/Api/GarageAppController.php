<?php

namespace App\Controller\Api;

use App\Repository\GarageAppRepository;
use App\Trait\Controller\ApiTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/api/garage', name: 'api.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'json', utf8: true)]
final class GarageAppController extends AbstractController
{
    use ApiTrait;

    #[Route('/index', name: 'index', methods: ['GET'])]
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
