<?php

namespace App\Controller\Front\Page\Search;

use App\DTO\Search\RaceDTO;
use App\Form\Front\Search\RaceType;
use App\Repository\RaceAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/search/', name: 'app.page.search.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class RaceController extends AbstractController
{
    #[Route('race.php', name: 'race', methods: ['GET', 'POST'])]
    public function race(Request $request, RaceAppRepository $repository, TranslatorInterface $translator): Response
    {
        // Variables
        $title = $translator->trans('text.race');

        // Form
        $search = new RaceDTO();
        $form   = $this->createForm(RaceType::class, $search)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($search);
        } else {
            $result = [];
        }

        return $this->render('@App/front/contents/race.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $translator->trans('text.search'), 'level2' => $title],
            'links'           => ['index' => 'app.page.search.race'],
            'entities'        => $result,
            'form'            => $form->createView(),
            'count'           => count($result),
        ]);
    }
}
