<?php

declare(strict_types=1);

namespace App\Interface;

interface CacheServiceInterface
{
    public function cacheCreate(): array;

    public function cacheDelete(): void;

}
