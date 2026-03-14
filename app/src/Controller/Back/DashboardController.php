<?php

declare(strict_types=1);

namespace App\Controller\Back;

use App\Toolbox\Trait\Controller\WebController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\InvalidArgumentException;
use Symfony\Component\Filesystem\Exception\RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin',
    name: 'admin.dashboard.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class DashboardController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index = 'admin.dashboard.index';

    #[Route('/index.php', name: 'index')]
    public function index(Request $request): Response
    {
        // Variables
        $home  = $this->translator->trans('text.back-office');
        $title = $this->translator->trans('text.dashboard');

        $this->addFlash('primary', 'Welcome to Admin !');

        return $this->render('@App/contents/back/dashboard/index.html.twig', [
            'controller_name' => $title . " - " . $home,
            'breadcrumb'      => self::Breadcrump($home, $title),
            'container'       => 'container-fluid',
            'current_page'    => $request->attributes->get('_route'),
       ]);
    }

    #[Route('/cache.php', name: 'cache')]
    public function cache(): Response
    {
        // Get Directory
        $directory = $this->getParameter('folders.cache');

        // Get Key Name of Cache
        $caches = array_keys($this->getParameter('cache_lifetime'));

        // File System
        $filesystem = new Filesystem();

        foreach ($caches as $name) {
            try {
                $filesystem->remove($directory . $name);
            } catch (InvalidArgumentException $e) {
                throw new RuntimeException($e->getMessage());
            }
        }

        // Flash Message
        $this->addFlash('success', [
            'title'   => $this->translator->trans('text.cache'),
            'message' => $this->translator->trans('notification.cache')
        ]);

        return $this->redirectToIndex();
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('admin.dashboard.index', ['_locale' => 'en'], Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
