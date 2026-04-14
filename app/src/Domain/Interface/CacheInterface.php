<?php

declare(strict_types=1);

namespace App\Domain\Interface;

interface CacheInterface
{
    /**
     * @return array
     */
    public function cacheCreate(): array;

    /**
     * @return void
     */
    public function cacheDelete(): void;
}
