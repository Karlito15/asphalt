<?php

namespace App\Controller\Web\Page;

use App\Repository\GarageBooleanRepository;
use Psr\Cache\InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/filter-by-', name: 'app.page.filter.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
class FilterController extends AbstractController
{
    public function __construct(
        private readonly GarageBooleanRepository $boolean,
        private readonly TranslatorInterface $translator,
    ) {}

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    #[Route('locked-{letter}.php', name: 'locked', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function locked(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.locked');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.locked',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('locked.', $letter, ['where' => 'locked', 'value' => true]),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    #[Route('unlock-{letter}.php', name: 'unlock', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function unlock(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.unlock');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.unlock',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('unlock.', $letter, ['where' => 'locked', 'value' => false]),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    #[Route('to-unlock-{letter}.php', name: 'to.unlock', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function toUnlock(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.to.unlock');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.to.unlock',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('to.unlock.', $letter, ['where' => 'toUnlock', 'value' => true]),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    #[Route('to-upgrade-{letter}.php', name: 'to.upgrade', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function toUpgrade(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.to.upgrade');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.to.upgrade',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('to.upgrade.', $letter, ['where' => 'toUpgrade', 'value' => true]),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    #[Route('gold-{letter}.php', name: 'gold', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function gold(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.gold');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.gold',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('gold.', $letter, ['where' => 'gold', 'value' => true]),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    #[Route('to-gold-{letter}.php', name: 'to.gold', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function toGold(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.to.gold');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.to.gold',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('to.gold.', $letter, ['where' => 'toGold', 'value' => true]),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    private function createDataCache(string $namespace, string $letter, array $query): array
    {
        /** Variables */
        $lifetime = $this->container->get('parameter_bag')->get('cache_lifetime');
        $cacheName = strtolower($namespace . $letter);

        /** Cache */
        $cache = new FilesystemAdapter('garages', $lifetime['garage'], 'cache');
        $values = $cache->getItem($cacheName);
        if ($values->isHit()) {
            return $values->get();
        } else {
            $results = $this->boolean->getCarsByClass($letter, $query);

            $cache->get($cacheName, function (ItemInterface $item) use ($results) {
                $item->expiresAt(new \DateTime('+7 days'));
                $item->set($results);

                return $results;
            });
            $cache->save($cache->getItem($cacheName));

            return $results;
        }
    }
}
