<?php

declare(strict_types=1);

namespace App\Trait\Entity;

use App\Entity\RaceApp;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait RaceAppTrait
{
    public function setSlug(): static
    {
        $slugger = new AsciiSlugger();

        /** @var RaceApp $this  */
        $this->slug = $slugger->slug(
            (string) $this->getSeason())->lower() . '-' .
            $slugger->slug((string) $this->getTrack())->lower() . '-' .
            $slugger->slug((string) $this->getRaceOrder())->lower()
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
