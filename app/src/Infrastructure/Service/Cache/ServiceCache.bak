<?php

declare(strict_types=1);

namespace App\Application\Service\Cache;

trait ServiceCache
{
    /**
     * Retourne le temps de vie du cache définit dans le fichier des paramètres.
     *
     * @param string $cacheName
     * @return int
     */
    private function getCacheLifeTime(string $cacheName): int
    {
        $lifetime = $this->container->getParameter('cache_lifetime');

        return $lifetime[$cacheName] ?? 0;
    }
}
