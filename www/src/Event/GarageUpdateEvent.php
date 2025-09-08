<?php

namespace App\Event;

use App\Entity\AppGarage;

readonly class GarageUpdateEvent
{
    public function __construct(public AppGarage $garage) {}
}
