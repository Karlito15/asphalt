<?php

declare(strict_types=1);

namespace App\Application\Controller\API\Setting;

use App\Domain\Repository\SettingTagRepository;
use App\Infrastructure\Abstract\Controller\AbstractAPIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'api/setting/tag',
    name: 'api.setting.tag.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class TagController extends AbstractAPIController
{
    #[Route(path: '/index', name: 'index', methods: ['GET'])]
    public function index(SettingTagRepository $repository): JsonResponse
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

    #[Route(path: '/{id}', name: 'detail', methods: ['GET'])]
    public function detail(
        int $id,
        SettingTagRepository $repository
    ): JsonResponse
    {
        return $this->json(
            $repository->findOneBy(['id' => $id]),
            Response::HTTP_OK,
            self::getHeaders(),
            self::getContext([
                'groups' => ['detail'],
            ])
        );
    }
}
