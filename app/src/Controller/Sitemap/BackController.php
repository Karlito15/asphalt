<?php

namespace App\Controller\Sitemap;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BackController extends AbstractController
{
    #[Route('/sitemap/back', name: 'app_sitemap_back')]
    public function index(): Response
    {
        return $this->render('sitemap/back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
}
