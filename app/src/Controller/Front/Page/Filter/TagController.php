<?php

declare(strict_types=1);

namespace App\Controller\Front\Page\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/pages/filter',
    name: 'app.page.filter.',
    requirements: ['letter' => Requirement::ASCII_SLUG],
    options: ['expose' => false],
    defaults: ['letter' => 'S'],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TagController extends AbstractController
{
    #[Route('/tag/{tag}.php', name: 'tag')]
    public function index(): Response
    {
        return $this->render('front/page/filter/tag/index.html.twig', [
            'controller_name' => 'Tag',
        ]);
    }
}
