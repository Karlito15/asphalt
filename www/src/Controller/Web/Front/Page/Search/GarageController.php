<?php

namespace App\Controller\Web\Front\Page\Search;

use App\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/search-', name: 'app.page.search.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class GarageController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('garage.php', name: 'garage', methods: ['GET', 'POST'])]
    public function garage(Request $request, GarageAppRepository $repository): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.search.garage');
//        $search = new SearchGarageDTO();
//        $form   = $this->createForm(GarageDTOType::class, $search)->handleRequest($request);
        $result = [];

//        if ($form->isSubmitted() && $form->isValid()) {
//            $result = $repository->search($search);
//            dump($result);
//        }

        return $this->render('@App/contents/front/page/search.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Search', 'lvl2' => $title],
            'index'           => 'app.page.search.garage',
//            'form'            => $form->createView(),
            'garages'         => $result,
            'count'           => count($result),
        ]);
    }
//    #[Route('/garage', name: 'app_garage')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/GarageController.php',
//        ]);
//    }
}
