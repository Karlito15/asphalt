<?php

declare(strict_types=1);

namespace App\Interface;

interface ServiceCacheInterface
{
    public function cacheCreate(): array;

    public function cacheDelete(): void;
}
