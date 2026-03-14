<?php

declare(strict_types=1);

namespace App\Controller\Front\Search;

use App\Toolbox\Trait\Controller\WebController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/pages/search',
    name: 'app.page.search.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class GarageController extends AbstractController
{
    use WebController;

    #[Route(path: '/garage.php', name: 'garage', methods: ['GET', 'POST'])]
    public function garage(Request $request): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.search');
        $title  = $this->translator->trans('text.garage');

        ### Datas
//        return $this->render('@App/front/page/search/garage/index.html.twig', [
        return $this->render('@App/contents/front/page/coming-soon.html.twig', [
            'controller_name' => 'Garage',
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => [],
        ]);
    }
}
