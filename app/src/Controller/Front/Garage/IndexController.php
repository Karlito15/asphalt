<?php

declare(strict_types=1);

namespace App\Controller\Front\Garage;

use App\Toolbox\File\YAML;
use App\Toolbox\Trait\Controller\WebController;
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
final class IndexController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /** @description link to the delete page */
    private static string $delete = 'app.garage.delete';

    /** @description name of folder's Extraction  */
    private static string $folder = 'list';

    /** @description name of file's Extraction  */
    private static string $file = 'garage.yaml';

    #[Route(path: '/index.php', name: 'index')]
//    #[Cache(expires: 'tomorrow', maxage: 10, public: true, mustRevalidate: true)]
    public function index(Request $request): Response
    {
        // Variables
        $home  = $this->translator->trans('text.garage');
        $title = $this->translator->trans('text.all.cars');

        // Datas
        $datas = $this->getExtractionFolder();

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::getBreadcrump($home, $title),
            'links'           => self::getLinksPage(),
            'entities'        => YAML::FileToArray($datas),
        ]);
    }
}
