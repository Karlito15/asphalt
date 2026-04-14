<?php

declare(strict_types=1);

namespace App\Application\Controller\Api\Setting;

use App\Application\Service\Controller\ApiController;
use App\Domain\Repository\SettingLevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'api/setting/level',
    name: 'api.setting.level.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class LevelController extends AbstractController
{
    use ApiController;

    #[Route(path: '/index', name: 'index')]
    public function index(SettingLevelRepository $repository): JsonResponse
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
