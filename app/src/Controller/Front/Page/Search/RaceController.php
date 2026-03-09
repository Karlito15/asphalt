<?php

declare(strict_types=1);

namespace App\Controller\Front\Page\Search;

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
final class RaceController extends AbstractController
{
    #[Route(path: '/race.php', name: 'race', methods: ['GET', 'POST'])]
    public function race(): Response
    {
        return $this->render('@App/front/page/search/race/index.html.twig', [
            'controller_name' => 'Race',
        ]);
    }
}
