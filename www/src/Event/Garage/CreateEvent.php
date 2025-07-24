<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Entity\GarageApp;

final readonly class CreateEvent
{
    public function __construct(
        public GarageApp $garage
    )
    {
        echo $this->garage->getModel();
    }
}
