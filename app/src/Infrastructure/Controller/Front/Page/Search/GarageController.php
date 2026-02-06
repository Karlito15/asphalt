<?php

namespace App\Infrastructure\Controller\Front\Page\Search;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GarageController extends AbstractController
{
    #[Route('/front/page/search/garage', name: 'app_front_page_search_garage')]
    public function index(): Response
    {
        return $this->render('@App/front/page/search/garage/index.html.twig', [
            'controller_name' => 'GarageController',
        ]);
    }
}
