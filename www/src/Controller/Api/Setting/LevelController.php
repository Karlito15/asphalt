<?php

namespace App\Controller\Api\Setting;

use App\Able\ControllerApiAble;
use App\Repository\SettingLevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/setting/level', format: 'json', utf8: true)]
class LevelController extends AbstractController
{
	use ControllerApiAble;

    #[Route('/index', name: 'api_setting_level_index')]
    public function index(SettingLevelRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
