<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Entity;

use App\Persistence\Entity\GarageApp;

/**
 * For Relationship
 */
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
