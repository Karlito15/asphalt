<?php

declare(strict_types=1);

namespace App\Controller\Front\Garage;

use App\Toolbox\File\YAML;
use App\Toolbox\Trait\Controller\WebController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class ReadController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /** @description link to the delete page */
    private static string $delete = 'app.garage.delete';

    /** @description name of folder's Extraction  */
    private static string $folder = 'sheet';

    /** @description name of file's Extraction  */
    private static string $file = 'garage';

    #[Route('/read/{slug}-{id}.php', name: 'read', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG])]
    public function read(Request $request): Response// , GarageApp $garage
    {
        // File
        $file   = $this->getExtractionFolder() . '/' . $request->attributes->get('slug') . '.yaml';
        $garage = YAML::FileToArray($file);

        // Variables
        $home  = $this->translator->trans('text.garage');
        $title = $garage['settingBrand']['name'] . ' ' . $garage['model'];

        return $this->render('@App/contents/front/garage/read.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container-fluid',
            'breadcrumb'      => self::getBreadcrump($home, $title),
            'links'           => self::getLinksPage(),
            'entity'          => $garage,
        ]);
    }
}
