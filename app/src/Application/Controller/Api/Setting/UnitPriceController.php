<?php

declare(strict_types=1);

namespace App\Application\Controller\Api\Setting;

use App\Application\Service\Controller\ApiController;
use App\Domain\Repository\SettingUnitPriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'api/setting/unit-price',
    name: 'api.setting.unit-price.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class UnitPriceController extends AbstractController
{
    use ApiController;

    #[Route(path: '/index', name: 'index')]
    public function index(SettingUnitPriceRepository $repository): JsonResponse
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
