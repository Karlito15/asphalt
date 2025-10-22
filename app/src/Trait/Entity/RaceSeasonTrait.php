<?php

declare(strict_types=1);

namespace App\Trait\Entity;

use App\Entity\RaceSeason;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait RaceSeasonTrait
{
    public function setSlug(): static
    {
        $slugger = new AsciiSlugger();

        /** @var RaceSeason $this  */
        $this->slug = $this->getChapter() . ' || ' . $slugger->slug($this->getName())->lower();

        return $this;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var RaceSeason $object */
        $object = $args->getObject();
        if ($object instanceof RaceSeason) {
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
        /* @var RaceSeason $object */
        $object = $args->getObject();
        if ($object instanceof RaceSeason) {// Slug
            $object->setSlug();
        }
    }
}
