<?php

namespace App\Controller\Web\Page;

use App\DTO\SearchGarageDTO;
use App\DTO\SearchRaceDTO;
use App\Form\Search\GarageDTOType;
use App\Form\Search\RaceDTOType;
use App\Repository\AppGarageRepository;
use App\Repository\AppRaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/search-', name: 'app.page.search.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class SearchController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('garage.php', name: 'garage')]
    public function garage(Request $request, AppGarageRepository $repository): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.search.garage');
        $search = new SearchGarageDTO();
        $form   = $this->createForm(GarageDTOType::class, $search)->handleRequest($request);
        $result = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($search);
            dump($result);
        }

        return $this->render('@App/app/page/search.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Search', 'lvl2' => $title],
            'index'           => 'app.page.search.garage',
            'form'            => $form->createView(),
            'garages'         => $result,
            'count'           => count($result),
        ]);
    }

    #[Route('race.php', name: 'race')]
    public function race(Request $request, AppRaceRepository $repository): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.search.race');
        $search = new SearchRaceDTO();
        $form   = $this->createForm(RaceDTOType::class, $search)->handleRequest($request);
        $result = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($search);
        }

        return $this->render('@App/app/page/search.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Search', 'lvl2' => $title],
            'index'           => 'app.page.search.race',
            'form'            => $form->createView(),
            'races'           => $result,
            'count'           => count($result),
        ]);
    }
}
