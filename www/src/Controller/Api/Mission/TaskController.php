<?php

namespace App\Controller\Api\Mission;

use App\Able\ControllerApiAble;
use App\Repository\MissionTaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/mission/task', format: 'json', utf8: true)]
class TaskController extends AbstractController
{
	use ControllerApiAble;

    #[Route('/index', name: 'api_mission_task_index')]
    public function index(MissionTaskRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
