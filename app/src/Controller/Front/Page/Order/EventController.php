<?php

declare(strict_types=1);

namespace App\Controller\Front\Page\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/pages/order',
    name: 'app.page.order.',
    requirements: ['letter' => Requirement::ASCII_SLUG],
    options: ['expose' => false],
    defaults: ['letter' => 'S'],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class EventController extends AbstractController
{
    #[Route(path: '/event/class-{letter}.php', name: 'event')]
    public function eventToken(): Response
    {
        return $this->render('@App/contents/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }
}
