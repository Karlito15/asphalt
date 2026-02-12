<?php

namespace App\Controller\Front\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/pages/search',
    name: 'app.page.search.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class SearchController extends AbstractController
{
    #[Route(path: 'garage.php', name: 'garage', methods: ['GET', 'POST'])]
    public function garage(): Response
    {
        return $this->render('@App/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }

    #[Route('race.php', name: 'race', methods: ['GET', 'POST'])]
    public function race(): Response
    {
        return $this->render('@App/front/page/search/race/index.html.twig', [
            'controller_name' => 'Race',
        ]);
    }
}
