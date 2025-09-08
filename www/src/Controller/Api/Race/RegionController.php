<?php

namespace App\Controller\Api\Race;

use App\Able\ControllerApiAble;
use App\Repository\RaceRegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/race/region', format: 'json', utf8: true)]
class RegionController extends AbstractController
{
	use ControllerApiAble;

    #[Route('/index', name: 'api_race_region_index')]
    public function index(RaceRegionRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
