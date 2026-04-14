<?php

namespace App\Application\Controller\Sitemap;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/sitemap',
    name: 'sitemap.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'xml',
    utf8: true
)]
final class BundleController extends AbstractController
{
    #[Route('/bundle.xml', name: 'bundle')]
    public function bundle(): Response
    {
        return $this->render('application/controller/sitemap/bundle/index.html.twig', [
            'controller_name' => 'BundleController',
        ]);
    }
}
