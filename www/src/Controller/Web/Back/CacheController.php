<?php

namespace App\Controller\Web\Back;

use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin', name: 'app.cache.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class CacheController extends AbstractController
{
    #[Route('/cache.php', name: 'index')]
    public function index(TranslatorInterface $translator): Response
    {
        // Get LifeTime Cache
        $caches = array_keys($this->getParameter('cache_lifetime'));

        foreach ($caches as $name) {
            $cache = new FilesystemAdapter($name, 361, 'cache');
            try {
                $cache->deleteItems([$name]);
            } catch (InvalidArgumentException $e) {
                throw new \RuntimeException($e->getMessage());
            }
        }

        $this->addFlash('success', $translator->trans('app.flash.error'));

        return $this->redirectToRoute('app.dashboard.admin');
    }
}
