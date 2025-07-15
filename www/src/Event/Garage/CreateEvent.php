<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Entity\GarageApp;

final class CreateEvent
{
    public function __construct(
        private readonly GarageApp $garage
    )
    {
        echo $this->garage->getModel();
    }
}
