<?php

namespace App\Service\Entities;

use App\Entity\GarageBlueprint;
use App\Entity\SettingBlueprint;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

trait BlueprintService
{
    public function setTotal(): static
    {
		$subtotal = $this->getStar2() + $this->getStar3() + $this->getStar4() + $this->getStar5() + $this->getStar6();

		if ($this->getStar1() === 'Key') {
			$this->total = $subtotal;
		} else {
			$this->total = (int) $this->getStar1() + $subtotal;
		}

		return $this;
    }

    public function setSlug(): static
    {
        $this->slug =
            strtolower(str_pad($this->getStar1(), 3, '0', STR_PAD_LEFT)).' - '.
            str_pad($this->getStar2(), 2, '0', STR_PAD_LEFT).' - '.
            str_pad($this->getStar3(), 2, '0', STR_PAD_LEFT).' - '.
            str_pad($this->getStar4(), 2, '0', STR_PAD_LEFT).' - '.
            str_pad($this->getStar5(), 2, '0', STR_PAD_LEFT).' - '.
            str_pad($this->getStar6(), 2, '0', STR_PAD_LEFT).' || '.
            strtolower(str_pad($this->getTotal(), 3, '0', STR_PAD_LEFT))
        ;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageBlueprint) {
            $object->setTotal();
        }
        if ($object instanceof SettingBlueprint) {
            $object->setTotal()->setSlug();
        }
    }

    #[ORM\PostUpdate]
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageBlueprint) {
            $object->setTotal();
            $args->getObjectManager()->getRepository(GarageBlueprint::class)->save($object, true);
        }
        if ($object instanceof SettingBlueprint) {
            $object->setTotal()->setSlug();
            $args->getObjectManager()->getRepository(SettingBlueprint::class)->save($object, true);
        }
    }
}
