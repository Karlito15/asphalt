<?php

namespace App\Controller\Front\Page\Search;

use App\DTO\Search\GarageDTO;
use App\Form\Front\Search\GarageType;
use App\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/search/', name: 'app.page.search.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class GarageController extends AbstractController
{
    #[Route('garage.php', name: 'garage', methods: ['GET', 'POST'])]
    public function garage(Request $request, GarageAppRepository $repository, TranslatorInterface $translator): Response
    {
        // Variables
        $title = $translator->trans('text.garage');

        // Form
        $search = new GarageDTO();
        $form   = $this->createForm(GarageType::class, $search)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($search);
        } else {
            $result = [];
        }

        return $this->render('@App/front/contents/garage/index.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $translator->trans('text.search'), 'level2' => $title],
            'links'           => ['index' => 'app.page.search.garage'],
            'entities'        => $result,
            'form'            => $form->createView(),
            'count'           => count($result),
        ]);
    }
}
