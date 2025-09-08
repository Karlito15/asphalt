<?php

namespace App\Controller\Api\Setting;

use App\Able\ControllerApiAble;
use App\Repository\SettingBlueprintRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/setting/blueprint', format: 'json', utf8: true)]
class BlueprintController extends AbstractController
{
	use ControllerApiAble;

 	#[Route('/index', name: 'api_setting_blueprint_index', methods: ['GET'])]
    public function index(SettingBlueprintRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
