<?php

declare(strict_types=1);

namespace App\Application\Controller\Api\Setting;

use App\Application\Service\Controller\ApiController;
use App\Domain\Repository\SettingBrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'api/setting/brand',
    name: 'api.setting.brand.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class BrandController extends AbstractController
{
    use ApiController;

    #[Route(path: '/index', name: 'index')]
    public function index(SettingBrandRepository $repository): JsonResponse
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
