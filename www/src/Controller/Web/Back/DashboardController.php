<?php

namespace App\Controller\Web\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '{_locale<%app.supported_locales%>}/admin', name: 'app.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    private static string $page = 'Dashboard';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route(path: '/admin.php', name: 'admin')]
    public function admin(): Response
    {
        $title = $this->translator->trans('app.dashboard.admin.title');

        return $this->render('@App/contents/back/dashboard/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app.dashboard.index', [
            '_locale' => 'en'
        ], Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
