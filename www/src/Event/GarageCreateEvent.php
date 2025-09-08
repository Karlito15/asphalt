<?php

namespace App\Event;

use App\Entity\AppGarage;

readonly class GarageCreateEvent
{
    public function __construct(public AppGarage $garage) {}
}
