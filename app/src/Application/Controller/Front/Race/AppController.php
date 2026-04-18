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

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceAppRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.race');
        $title = $this->translator->trans('text.all.races');

        return $this->render('@App/contents/front/page/race.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->findAll(),
        ]);
    }
}
