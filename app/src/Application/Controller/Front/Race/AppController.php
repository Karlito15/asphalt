<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Race;

use App\Application\Service\Controller\WebController;
use App\Domain\Repository\RaceAppRepository;
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
final class AppController extends AbstractController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'app.race.index',
      'create' => 'admin.race.app.create',
      'read'   => null,
      'update' => 'admin.race.app.update',
      'delete' => 'admin.race.app.delete',
    ];

//    /** @description name of folder's Extraction  */
//    private static string $folder = 'index';

//    /** @description name of file's Extraction  */
//    private static string $file = 'app-race.yaml';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceAppRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.race');
        $title = $this->translator->trans('text.all.races');

        ### Datas
//        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/page/race.html.twig', [
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::LinksPage(),
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->findAll(),
//            'entities'        => YAML::FileToArray($datas),
        ]);
    }
}
