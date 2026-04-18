<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Search;

use App\Application\DTO\Search\RaceDTO;
use App\Application\Service\Controller\WebController;
use App\Domain\Form\Front\Search\RaceAppType;
use App\Domain\Repository\RaceAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/search',
    name: 'app.search.',
    options: ['expose' => false],
    methods: ['GET', 'POST'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class RaceController extends AbstractController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'app.search.race',
      'create' => null,
      'read'   => null,
      'update' => null,
      'delete' => null,
    ];

    #[Route(path: '/race.php', name: 'race')]
    public function race(Request $request, RaceAppRepository $repository): Response
    {
        ### Variables
        $result = [];
        $home   = $this->translator->trans('text.search');
        $title  = $this->translator->trans('text.race');
        $dto    = new RaceDTO();
        $form   = $this->createForm(RaceAppType::class, $dto)->handleRequest($request);

        ### Form
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($dto);
        }
        return $this->render('@App/contents/front/search/race.html.twig', [
            'container'        => 'container-fluid pt-4 px-4',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::$crud,
            'controller_name' => $home,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $result,
            'form'            => $form->createView(),
            'count'           => count($result),
        ]);
    }
}
