<?php

declare(strict_types=1);

namespace App\Infrastructure\Event\Garage;

use App\Domain\Entity\GarageApp;

final readonly class SettingEvent
{
    public function __construct(
        protected GarageApp $garage,
    ) {}

    /**
     * @return GarageApp
     */
    public function getGarage(): GarageApp
    {
        return $this->garage;
    }

    ### Begin::Setting Brand

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->garage->getSettingBrand()->getName();
    }

    ### End::Setting Brand

    ### Begin::Setting Class

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->garage->getSettingClass()->getValue();
    }

    ### End::Setting Class
}
