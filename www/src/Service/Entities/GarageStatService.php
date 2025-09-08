<?php

namespace App\Service\Entities;

use App\Entity\GarageStatMax;
use App\Entity\GarageStatMin;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

trait GarageStatService
{
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
