<?php

namespace App\Controller\Web\Front\Page\Search;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/pages/search-', name: 'app.page.search.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class RaceController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {}

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
//    #[Route('/race', name: 'app_race')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/RaceController.php',
//        ]);
//    }
}
