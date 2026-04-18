<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Page;

use App\Application\Service\Controller\WebController;
use App\Domain\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
final class OrderController extends AbstractController
{
    use WebController;

    #[Route(path: '/class/class-{letter}.php', name: 'class')]
    public function class(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.order');
        $title  = $this->translator->trans('text.class');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageOrder(['settingClass.value' => $letter], ['g.carOrder' => 'ASC']),
        ]);
    }

    #[Route(path: '/stat/class-{letter}.php', name: 'stat')]
    public function stat(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.order');
        $title  = $this->translator->trans('text.stat');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageOrder(['settingClass.value' => $letter], ['g.statOrder' => 'ASC']),
        ]);
    }
}
