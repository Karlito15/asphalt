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
final class StatusController extends AbstractController
{
    #[Route(path: '/gold/class-{letter}.php', name: 'gold')]
    public function gold(): Response
    {
        return $this->render('@App/contents/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }

    #[Route(path: '/locked/class-{letter}.php', name: 'locked')]
    public function locked(): Response
    {
        return $this->render('@App/contents/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }

    #[Route(path: '/to-gold/class-{letter}.php', name: 'to.gold')]
    public function toGold(): Response
    {
        return $this->render('@App/contents/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }

    #[Route(path: '/to-unlock/class-{letter}.php', name: 'to.unlock')]
    public function toUnlock(): Response
    {
        return $this->render('@App/contents/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }

    #[Route(path: '/to-upgrade/class-{letter}.php', name: 'to.upgrade')]
    public function toUpgrade(): Response
    {
        return $this->render('@App/contents/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }

    #[Route(path: '/unlock/class-{letter}.php', name: 'unlock')]
    public function unlock(): Response
    {
        return $this->render('@App/contents/front/page/search/garage/index.html.twig', [
            'controller_name' => 'Garage',
        ]);
    }
}
