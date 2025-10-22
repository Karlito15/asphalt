<?php

declare(strict_types=1);

namespace App\Event\Setting;

use App\Entity\GarageApp;

final readonly class TagEvent
{
    public function __construct(
        private readonly GarageApp $garage
    )
    {
        echo $this->garage->getModel();
    }
}
