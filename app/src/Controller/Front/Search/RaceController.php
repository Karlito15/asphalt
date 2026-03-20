<?php

declare(strict_types=1);

namespace App\Controller\Front\Search;

use App\Persistence\DTO\Search\RaceDTO;
use App\Persistence\Form\Search\RaceType;
use App\Persistence\Repository\RaceAppRepository;
use App\Toolbox\Trait\Controller\WebController;
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

    #[Route(path: '/race.php', name: 'race')]
    public function race(Request $request, RaceAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.search');
        $title  = $this->translator->trans('text.race');
        $result = [];

        ### Form
        $dto  = new RaceDTO();
        $form = $this->createForm(RaceType::class, $dto)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($dto);
        }

        ### Datas
        return $this->render('@App/contents/front/search/race.html.twig', [
            'controller_name' => $home,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
            'entities'        => $result,
            'form'            => $form->createView(),
            'count'           => count($result),
        ]);
    }
}
