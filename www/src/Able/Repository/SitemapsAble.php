<?php

namespace App\Able\Repository;

trait SitemapsAble
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
