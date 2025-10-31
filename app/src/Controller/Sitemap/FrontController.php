<?php

namespace App\Controller\Sitemap;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FrontController extends AbstractController
{
    #[Route('/sitemap/front', name: 'app_sitemap_front')]
    public function index(): Response
    {
        return $this->render('sitemap/front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
}
