<?php

namespace App\Interface;

interface AsphaltCacheInterface
{
    public function createDataCache(string $cacheName): array;

    public function deleteDataCache(): void;
}
