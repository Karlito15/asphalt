<?php

namespace App\Infrastructure\Controller\Front\Page\Search;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RaceController extends AbstractController
{
    #[Route('/front/page/search/race', name: 'app_front_page_search_race')]
    public function index(): Response
    {
        return $this->render('@App/front/page/search/race/index.html.twig', [
            'controller_name' => 'RaceController',
        ]);
    }
}
