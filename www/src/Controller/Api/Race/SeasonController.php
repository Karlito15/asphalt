<?php

namespace App\Controller\Api\Race;

use App\Able\ControllerApiAble;
use App\Repository\RaceSeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/race/season', format: 'json', utf8: true)]
class SeasonController extends AbstractController
{
	use ControllerApiAble;

    #[Route('/index', name: 'api_race_season_index')]
    public function index(RaceSeasonRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), Response::HTTP_OK, self::getHeaders(), self::getContext([
            'groups' => ['index'],
        ]));
    }
}
