<?php

namespace App\Controller\Back;

use App\Trait\Controller\WebTrait;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin', name: 'admin.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index = 'admin.dashboard.index';

    public function __construct(
        private readonly TranslatorInterface $translator
    )
    {}

    #[Route('/index.php', name: 'index')]
    public function index(): Response
    {
        // Variables
        $title = $this->translator->trans('text.dashboard');
        $back  = $this->translator->trans('text.back-office');

        return $this->render('@App/back/contents/dashboard.html.twig', [
            'controller_name' => $title . " - " . $back,
            'breadcrumb'      => ['level1' => $back, 'level2' => $title],
            'container'       => 'container',
        ]);
    }

    #[Route('/cache.php', name: 'cache')]
    public function cache(): Response
    {
        // Get Directory
        $cache = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
        $dir = $this->getParameter('kernel.project_dir') . $cache;

        // Get Key Name of Cache
        $caches = array_keys($this->getParameter('cache_lifetime'));

        // File System
        $filesystem = new Filesystem();

        foreach ($caches as $name) {
            try {
                $filesystem->remove($dir . $name);
            } catch (InvalidArgumentException $e) {
                throw new RuntimeException($e->getMessage());
            }
        }

        // Flash Message
        $this->addFlash('success', [
            'title' => $this->translator->trans('text.cache'),
            'message' => $this->translator->trans('notification.cache')
        ]);

        return $this->redirectToIndex();
    }
}
