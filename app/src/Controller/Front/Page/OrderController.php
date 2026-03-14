<?php

declare(strict_types=1);

namespace App\Controller\Front\Page;

use App\Toolbox\Trait\Controller\WebController;
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
    public function class(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.search');
        $title  = $this->translator->trans('text.class');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        return $this->render('@App/contents/front/page/coming-soon.html.twig', [
            'controller_name' => 'Garage',
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
        ]);
    }

    #[Route(path: '/stat/class-{letter}.php', name: 'stat')]
    public function stat(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.search');
        $title  = $this->translator->trans('text.stat');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        return $this->render('@App/contents/front/page/coming-soon.html.twig', [
            'controller_name' => 'Garage',
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
        ]);
    }
}
