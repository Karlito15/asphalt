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
final class FilterController extends AbstractController
{
    use WebController;

    #[Route(path: '/block/class-{letter}.php', name: 'block')]
    public function block(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.block');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([
                'status.unblock' => false,
                'settingClass.value' => $letter,
            ]),
        ]);
    }

    #[Route(path: '/gold/class-{letter}.php', name: 'gold')]
    public function gold(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.gold');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([
                'status.unblock' => true,
                'status.gold' => true,
                'settingClass.value' => $letter,
            ]),
        ]);
    }

    #[Route(path: '/unblock/class-{letter}.php', name: 'unblock')]
    public function unblock(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.unblock');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([
                'status.unblock' => true,
                'settingClass.value' => $letter,
            ]),
        ]);
    }

    #[Route(path: '/evo/class-{letter}.php', name: 'evo')]
    public function evo(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.evo');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([
                'status.evo' => true,
                'settingClass.value' => $letter,
            ]),
        ]);
    }

    #[Route(path: '/event-class-{letter}.php', name: 'event')]
    public function event(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.event.class');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([
                'status.eventClass' => true,
                'settingClass.value' => $letter,
            ]),
        ]);
    }

    #[Route(path: '/to-upgrade/class-{letter}.php', name: 'to.upgrade')]
    public function toUpgrade(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.upgrade');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([
                'status.toUpgrade' => true,
                'settingClass.value' => $letter,
            ]),
        ]);
    }

    #[Route(path: '/to-install-upgrade/class-{letter}.php', name: 'to.install.upgrade')]
    public function toInstallUpgrade(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.install.upgrade');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([]),
        ]);
    }

    #[Route(path: '/to-install-import/class-{letter}.php', name: 'to.install.import')]
    public function toInstallImport(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.install.import');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([]),
        ]);
    }

    #[Route(path: '/to-gold/class-{letter}.php', name: 'to.gold')]
    public function toGold(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.gold');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([]),
        ]);
    }

    #[Route(path: '/full-blueprint/class-{letter}.php', name: 'full.blueprint')]
    public function fullBlueprint(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.full.blueprint');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([]),
        ]);
    }

    #[Route(path: '/full-evo/class-{letter}.php', name: 'full.evo')]
    public function fullEvo(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.full.evo');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $home . ' by ' . $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->getGaragePageFilter([]),
        ]);
    }
}
