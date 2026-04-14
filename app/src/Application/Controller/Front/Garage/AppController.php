<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Garage;

use App\Application\Service\Controller\WebController;
use App\Domain\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class AppController extends AbstractController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'app.garage.index',
      'create' => 'app.garage.create',
      'read'   => 'app.garage.read',
      'update' => 'app.garage.update',
      'delete' => 'app.garage.delete',
    ];

//    /** @description name of folder's Extraction  */
//    private static string $folder = 'index';

//    /** @description name of file's Extraction  */
//    private static string $file = 'app-garage.yaml';

    #[Route(path: '/index.php', name: 'index')]
    public function index(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.garage');
        $title = $this->translator->trans('text.all.cars');

//        ### Datas
//        $datas = $this->ExtractionFolder();

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->findList(),
//            'entities'        => YAML::FileToArray($datas),
        ]);
    }
}
