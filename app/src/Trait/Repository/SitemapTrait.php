<?php

declare(strict_types=1);

namespace App\Trait\Repository;

trait SitemapTrait
{
    /**
     * Retourne les informations pour le sitemap
     *
     * @return array
     */
    public function sitemapDatas(): array
    {
        return $this->createQueryBuilder('g')->select('g.id')->orderBy('g.id', 'ASC')->getQuery()->getArrayResult();
    }
}
