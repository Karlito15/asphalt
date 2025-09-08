<?php

namespace App\Controller\Api;

use App\Able\ControllerApiAble;
use App\Repository\AppGarageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/garage', format: 'json', utf8: true)]
class GarageController extends AbstractController
{
    use ControllerApiAble;

    #[Route('/index', name: 'api.garage.index', methods: ['GET'])]
    public function index(AppGarageRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
