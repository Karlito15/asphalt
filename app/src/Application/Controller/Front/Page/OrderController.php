<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Page;

use App\Application\Service\Controller\WebController;
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

//    /** @description name of folder's Extraction  */
//    private static string $folder     = 'list';

//    /** @description name of file's Extraction  */
//    private static string $file       = '';

//    private static string $orderClass = 'order-by-class-%s.yaml';

//    private static string $orderStat  = 'order-by-stat-%s.yaml';

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
//        self::$file = sprintf(self::$orderClass, $letter);
//        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/order-class.html.twig', [
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => [],
//            'entities'        => YAML::FileToArray($datas),
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
//        self::$file = sprintf(self::$orderStat, $letter);
//        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/order-stat.html.twig', [
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => [],
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => [],
//            'entities'        => YAML::FileToArray($datas),
        ]);
    }
}
