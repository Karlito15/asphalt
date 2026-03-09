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
final class GarageController extends AbstractController
{
    #[Route(path: '/garage.php', name: 'garage', methods: ['GET', 'POST'])]
    public function garage(): Response
    {
        return $this->render('@App/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }
}
