<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Garage;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\GarageApp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG],
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class ReadController extends AbstractController
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
//    private static string $folder = 'sheet';

//    /** @description name of file's Extraction  */
//    private static string $file = 'garage';

    #[Route('/read/{slug}-{id}.php', name: 'read')]
    public function read(Request $request, GarageApp $garage): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.garage');
        $title = $garage->getSettingBrand()->getName() . ' ' . $garage->getModel();

        ### File
//        $file   = $this->ExtractionFolder() . '/' . $request->attributes->get('slug') . '.yaml';
//        $garage = YAML::FileToArray($file);

        return $this->render('@App/contents/front/garage/read.html.twig', [
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entity'          => $garage,
        ]);
    }
}
