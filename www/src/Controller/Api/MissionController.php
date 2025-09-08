<?php

namespace App\Controller\Api;

use App\Able\ControllerApiAble;
use App\Repository\AppMissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/mission', format: 'json', utf8: true)]
class MissionController extends AbstractController
{
    use ControllerApiAble;

    #[Route('/index', name: 'api_mission_index', methods: ['GET'])]
    public function index(AppMissionRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
