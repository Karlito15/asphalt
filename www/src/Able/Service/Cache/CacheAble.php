<?php

namespace App\Able\Service\Cache;

trait CacheAble
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
