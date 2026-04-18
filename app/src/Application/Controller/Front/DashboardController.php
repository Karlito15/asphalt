<?php

declare(strict_types=1);

namespace App\Application\Controller\Front;

use App\Application\Service\Controller\WebController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/',
    name: 'app.dashboard.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class DashboardController extends AbstractController
{
    use WebController;

    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(Request $request,): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.front-office');
        $title = $this->translator->trans('text.dashboard');

        ### Flash
        // $this->addFlash('primary', 'This is the Web App !');

        return $this->render('@App/contents/front/dashboard/index.html.twig', [
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'container'        => 'container-fluid pt-4 px-4',
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app.dashboard.index', ['_locale' => 'en'], Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
