<?php

namespace App\Controller\Api\Setting;

use App\Able\ControllerApiAble;
use App\Repository\SettingUnitPriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/setting/unit-price', format: 'json', utf8: true)]
class UnitPriceController extends AbstractController
{
	use ControllerApiAble;

    #[Route('/index', name: 'api_setting_unit_price_index')]
    public function index(SettingUnitPriceRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
