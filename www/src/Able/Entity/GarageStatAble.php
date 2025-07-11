<?php

declare(strict_types=1);

namespace App\Able\Entity;

use App\Entity\GarageApp;
use App\Entity\GarageStatMax;
use App\Entity\GarageStatMin;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

trait GarageStatAble
{
    public function __toString() : string
    {
        return $this->getGarage();
    }

    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    public function setSpeed(float $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getAcceleration(): ?float
    {
        return $this->acceleration;
    }

    public function setAcceleration(float $acceleration): static
    {
        $this->acceleration = $acceleration;

        return $this;
    }

    public function getHandly(): ?float
    {
        return $this->handly;
    }

    public function setHandly(float $handly): static
    {
        $this->handly = $handly;

        return $this;
    }

    public function getNitro(): ?float
    {
        return $this->nitro;
    }

    public function setNitro(float $nitro): static
    {
        $this->nitro = $nitro;

        return $this;
    }

    public function getAverage(): ?float
    {
        return $this->average;
    }

    /**
     * Calcule la moyenne des Stats pour une voiture
     *
     * @param float|null $speed
     * @param float|null $acceleration
     * @param float|null $handly
     * @param float|null $nitro
     * @return $this
     */
    public function setAverage(?float $speed, ?float $acceleration, ?float $handly, ?float $nitro): static
    {
        $total = $speed + $acceleration + $handly + $nitro;

        if ($total != 0) {
            $this->average = round(($total / 4), 2);
        } else {
            $this->average = 0;
        }

        return $this;
    }

    public function getGarage(): ?GarageApp
    {
        return $this->garage;
    }

    public function setGarage(?GarageApp $garage): static
    {
        $this->garage = $garage;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageStatMax or $object instanceof GarageStatMin) {
            // Set Average
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandly(), $this->getNitro());
        }
    }

    #[ORM\PostUpdate]
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageStatMax) {
            // Set Average
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandly(), $this->getNitro());
            $args->getObjectManager()->getRepository(GarageStatMax::class)->save($object, true);
        }
        if ($object instanceof GarageStatMin) {
            // Set Average
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandly(), $this->getNitro());
            $args->getObjectManager()->getRepository(GarageStatMin::class)->save($object, true);
        }
    }
}
