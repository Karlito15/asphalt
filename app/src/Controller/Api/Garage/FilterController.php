<?php

declare(strict_types=1);

namespace App\Controller\Api\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingClass;
use App\Persistence\Repository\GarageAppRepository;
use App\Persistence\Repository\GarageStatusControlRepository;
use App\Toolbox\Trait\Controller\ApiController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'api/filter',
    name: 'api.filter.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class FilterController extends AbstractController
{
    use ApiController;

    #[Route(path: '/status/{letter}', name: 'status')]
    public function status(
        EntityManagerInterface $entityManager,
        GarageAppRepository $repository,
        Request $request,
    ): JsonResponse
    {
        $letter  = strtoupper(($request->attributes->get('letter')));
        $class   = $entityManager->getRepository(SettingClass::class)->findByClass($letter);

        return $this->json(
            $repository->findBy(['settingClass' => $class]),
            Response::HTTP_OK,
            self::getHeaders(),
            self::getContext([
                'groups' => ['filter'],
            ])
        );
    }

    #[Route(path: '/toUnblock/{letter}', name: 'toUnblock')]
    public function toUnblock(
        EntityManagerInterface $entityManager,
        GarageStatusControlRepository $repository,
        Request $request,
    ): JsonResponse
    {
        $condition = ['toUnblock' => true];
        $letter    = strtoupper(($request->attributes->get('letter')));
        $class     = $entityManager->getRepository(SettingClass::class)->findByClass($letter);
        $garages   = $entityManager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
        $findBy    = array_merge($condition, ['garage' => $garages]);

        return $this->json(
            $repository->findBy($findBy),
            Response::HTTP_OK,
            self::getHeaders(),
            self::getContext([
                'groups' => ['filter'],
            ])
        );
    }

    #[Route(path: '/toInstallUpgrade/{letter}', name: 'toInstallUpgrade')]
    public function toInstallUpgrade(
        EntityManagerInterface $entityManager,
        GarageStatusControlRepository $repository,
        Request $request,
    ): JsonResponse
    {
        $condition = ['fullUpgrade' => false, 'toInstallUpgrade' => true];
        $letter    = strtoupper(($request->attributes->get('letter')));
        $class     = $entityManager->getRepository(SettingClass::class)->findByClass($letter);
        $garages   = $entityManager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
        $findBy    = array_merge($condition, ['garage' => $garages]);

        return $this->json(
            $repository->findBy($findBy),
            Response::HTTP_OK,
            self::getHeaders(),
            self::getContext([
                'groups' => ['filter'],
            ])
        );
    }
}
