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
    path: '/{_locale<%app.supported_locales%>}/race',
    name: 'app.race.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class RaceAppController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index = 'app.race.index';

    /** @description link to the create page */
    private static string $create = 'admin.race.app.create';

    /** @description link to the delete page */
    private static string $delete = 'admin.race.app.delete';

    /** @description name of folder's Extraction  */
    private static string $folder = 'index';

    /** @description name of file's Extraction  */
    private static string $file = 'app-race.yaml';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // Variables
        $home  = $this->translator->trans('text.race');
        $title = $this->translator->trans('text.all.races');

        // Datas
        $datas = $this->ExtractionFolder();

//        dd(YAML::FileToArray($datas));

        return $this->render('@App/contents/front/page/race.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => self::LinksPage(),
            'entities'        => YAML::FileToArray($datas),
        ]);
    }
}
