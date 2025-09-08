<?php

namespace App\Controller\Api\Setting;

use App\Able\ControllerApiAble;
use App\Repository\SettingBrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/setting/brand', format: 'json', utf8: true)]
class BrandController extends AbstractController
{
	use ControllerApiAble;

    #[Route('/index', name: 'api_setting_brand_index')]
    public function index(SettingBrandRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
