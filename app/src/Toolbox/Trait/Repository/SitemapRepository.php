<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Repository;

trait SitemapRepository
{
    /**
     * Retourne les informations pour le sitemap
     *
     * @return array
     */
    public function sitemap(): array
    {
        return $this->createQueryBuilder('g')
            ->select('g.id')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
