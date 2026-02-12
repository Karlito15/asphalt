<?php

declare(strict_types=1);

namespace App\Persistence\Trait\Entity;

use App\Persistence\Entity\RaceApp;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait RaceAppableEntity
{
    public function setSlug(): static
    {
        $slugger = new AsciiSlugger();

        /** @var RaceApp $this  */
        $this->slug = $slugger->slug(
            (string) $this->getSeason())->lower() . '-' .
            $slugger->slug((string) $this->getRaceOrder())->lower() . '-' .
            $slugger->slug((string) $this->getTrack())->lower()
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
