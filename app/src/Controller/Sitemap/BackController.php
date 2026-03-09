<?php

declare(strict_types=1);

namespace App\Controller\Sitemap;

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
final class BackController extends AbstractController
{
    #[Route('/back.xml', name: 'back')]
    public function index(): Response
    {
        return $this->render('@App/contents/sitemap/back/index.html.twig', [
            'controller_name' => 'Back',
        ]);
    }
}
