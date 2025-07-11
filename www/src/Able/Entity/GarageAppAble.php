<?php

declare(strict_types=1);

namespace App\Able\Entity;

use App\Entity\GarageApp;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait GarageAppAble
{
    public function setSlug(): static
    {
        $slugger    = new AsciiSlugger();
        $this->slug = $slugger->slug($this->getSettingBrand()->getName())->lower() . '-' . $slugger->slug($this->getModel())->lower();

        return $this;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var GarageApp $object */
        $object = $args->getObject();
        if ($object instanceof GarageApp) {
            $object->setSlug();
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PreUpdate]
    public function preUpdate(LifecycleEventArgs $args): void
    {
        /* @var GarageApp $object */
        $object = $args->getObject();
        if ($object instanceof GarageApp) {
            $object->setSlug();
        }
    }
}
