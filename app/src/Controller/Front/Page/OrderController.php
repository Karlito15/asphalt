<?php

namespace App\Controller\Front\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/pages/order',
    name: 'app.page.order.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class OrderController extends AbstractController
{
    #[Route('class/class-{letter}.php', name: 'class', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function class(): Response
    {
        return $this->render('@App/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }

    #[Route('event/class-{letter}.php', name: 'event', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function eventToken(): Response
    {
        return $this->render('@App/front/page/search/race/index.html.twig', [
            'controller_name' => 'Race',
        ]);
    }

    #[Route('stat/class-{letter}.php', name: 'stat', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function stat(): Response
    {
        return $this->render('@App/front/page/search/race/index.html.twig', [
            'controller_name' => 'Race',
        ]);
    }
}
