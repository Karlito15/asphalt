<?php

declare(strict_types=1);

namespace App\Controller\Front\Page;

use App\Toolbox\File\YAML;
use App\Toolbox\Trait\Controller\WebController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/mission',
    name: 'app.mission.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class MissionAppController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index    = 'app.mission.index';

    /** @description link to the create page */
    private static string $create   = 'admin.mission.app.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.mission.app.delete';

    /** @description name of folder's Extraction  */
    private static string $folder = 'list';

    /** @description name of file's Extraction  */
    private static string $file = 'app-mission.yaml';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // Variables
        $home  = $this->translator->trans('text.mission');
        $title = $this->translator->trans('text.all.missions');

        // Datas
        $datas = $this->ExtractionFolder();

//        dd(YAML::FileToArray($datas));

        return $this->render('@App/contents/front/page/mission.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => self::LinksPage(),
            'entities'        => YAML::FileToArray($datas),
        ]);
    }
}
