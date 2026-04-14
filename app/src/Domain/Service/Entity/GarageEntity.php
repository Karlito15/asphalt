<?php

declare(strict_types=1);

namespace App\Domain\Service\Entity;

use App\Domain\Entity\GarageApp;

trait GarageEntity
{
    public function getGarage(): ?GarageApp
    {
        return $this->garage;
    }

    public function setGarage(?GarageApp $garage): static
    {
        $this->garage = $garage;

        return $this;
    }
}
