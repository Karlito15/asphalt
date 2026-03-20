<?php

declare(strict_types=1);

namespace App\Controller\Front\Search;

use App\Persistence\DTO\Search\GarageDTO;
use App\Persistence\Form\Search\GarageType;
use App\Persistence\Repository\GarageAppRepository;
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
final class GarageController extends AbstractController
{
    use WebController;

    #[Route(path: '/garage.php', name: 'garage')]
    public function garage(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.search');
        $title  = $this->translator->trans('text.garage');
        $result = [];

        ### Form
        $dto  = new GarageDTO();
        $form = $this->createForm(GarageType::class, $dto)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($dto);
        }

        ### Datas
        return $this->render('@App/contents/front/search/garage.html.twig', [
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
