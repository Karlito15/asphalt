<?php

declare(strict_types=1);

namespace App\Able\Entity;

use App\Entity\RaceApp;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait RaceAppAble
{
    public function setSlug(): static
    {
        $slugger = new AsciiSlugger();

        /** @var RaceApp $this  */
        $this->slug = $slugger->slug(
            $this->getSeason())->lower() . '-' .
            $slugger->slug($this->getTrack())->lower() . '-' .
            $slugger->slug($this->getRaceOrder())->lower()
        ;

        return $this;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var RaceApp $object */
        $object = $args->getObject();
        if ($object instanceof RaceApp) {
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
        /* @var RaceApp $object */
        $object = $args->getObject();
        if ($object instanceof RaceApp) {
            $object->setSlug();
        }
    }
}
