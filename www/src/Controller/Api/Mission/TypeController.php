<?php

namespace App\Controller\Api\Mission;

use App\Able\ControllerApiAble;
use App\Repository\MissionTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/mission/type', format: 'json', utf8: true)]
class TypeController extends AbstractController
{
	use ControllerApiAble;

    #[Route('/index', name: 'api_mission_type_index')]
    public function index(MissionTypeRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
