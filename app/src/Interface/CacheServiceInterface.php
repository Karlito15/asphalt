<?php

declare(strict_types=1);

namespace App\Interface;

interface CacheServiceInterface
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
