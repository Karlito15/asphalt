<?php

declare(strict_types=1);

namespace App\Controller\Front\Page;

use App\Toolbox\File\YAML;
use App\Toolbox\Trait\Controller\WebController;
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

    /** @description name of folder's Extraction  */
    private static string $folder                    = 'list';

    /** @description name of file's Extraction  */
    private static string $file                      = '';

    private static string $block                     = 'filter-block-%s.yaml';

    private static string $gold                      = 'filter-gold-%s.yaml';

    private static string $unblock                   = 'filter-unblock-%s.yaml';

    private static string $evo                       = 'filter-evo-%s.yaml';

    private static string $event                     = 'filter-event-class-%s.yaml';

    private static string $toUpgrade                 = 'filter-to-upgrade-%s.yaml';

    private static string $orderClass                = 'order-by-class-%s.yaml';

    private static string $orderStat                 = 'order-by-stat-%s.yaml';

    private static string $toUnblock                 = 'to-unblock-%s.yaml';

    private static string $toInstallUpgrade          = 'to-install-upgrade-%s.yaml';

    private static string $toInstallImport           = 'to-install-import-%s.yaml';

    private static string $toGold                    = 'to-gold-%s.yaml';

    private static string $fullBlueprint             = 'full-blueprint-%s.yaml';

    private static string $fullEvo                   = 'full-evo-%s.yaml';


    #[Route(path: '/block/class-{letter}.php', name: 'block')]
    public function block(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.block');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$block, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/gold/class-{letter}.php', name: 'gold')]
    public function gold(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.gold');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$gold, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/unblock/class-{letter}.php', name: 'unblock')]
    public function unblock(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.unblock');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$unblock, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/evo/class-{letter}.php', name: 'evo')]
    public function evo(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.evo');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$evo, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/event-class-{letter}.php', name: 'event')]
    public function eventToken(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.event.class');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$event, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/to-upgrade/class-{letter}.php', name: 'to.upgrade')]
    public function toUpgrade(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.upgrade');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$toUpgrade, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/to-unblock/class-{letter}.php', name: 'to.unblock')]
    public function toUnblock(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.unblock');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$toUnblock, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter-light.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/to-install-upgrade/class-{letter}.php', name: 'to.install.upgrade')]
    public function toInstallUpgrade(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.install.upgrade');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$toInstallUpgrade, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter-light.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/to-install-import/class-{letter}.php', name: 'to.install.import')]
    public function toInstallImport(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.install.import');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$toInstallImport, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter-light.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/to-gold/class-{letter}.php', name: 'to.gold')]
    public function toGold(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.to.gold');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$toGold, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter-light.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/full-blueprint/class-{letter}.php', name: 'full.blueprint')]
    public function fullBlueprint(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.full.blueprint');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$fullBlueprint, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter-light.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }

    #[Route(path: '/full-evo/class-{letter}.php', name: 'full.evo')]
    public function fullEvo(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.filter');
        $title  = $this->translator->trans('text.full.evo');
        $letter = self::Letter($request->attributes->get('letter'));
        $match  = self::ControlLetter($letter);

        // Letter Not Match
        $this->return404($match);

        ### Datas
        self::$file = sprintf(self::$fullEvo, $letter);
        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/filter-light.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => YAML::FileToArray($datas),
        ]);
    }
}
