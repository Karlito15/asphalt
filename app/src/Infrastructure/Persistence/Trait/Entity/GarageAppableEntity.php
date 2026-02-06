<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Trait\Entity;

use App\Infrastructure\Persistence\Entity\GarageApp;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait GarageAppableEntity
{
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set the slug for Garage
     *
     * @return $this
     */
    public function setSlug(): static
    {
        $slugger    = new AsciiSlugger();
        $this->slug = $slugger->slug($this->getSettingBrand()->getName())->lower() . '-' . $slugger->slug($this->getModel())->lower();

        return $this;
    }

    /**
     * Crée le slug
     *
     * @param PrePersistEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    #[NoReturn]
    public function prePersist(PrePersistEventArgs $args): void
    {
        /* @var GarageApp $object */
        $object = $args->getObject();
        if ($object instanceof GarageApp) {
            $object->setSlug();
        }
    }

    /**
     * Met à jour le slug si le model change
     *
     * @param PreUpdateEventArgs $args
     * @return void
     */
    #[ORM\PreUpdate]
    #[NoReturn]
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        /* @var GarageApp $object */
        $object = $args->getObject();
        if ($object instanceof GarageApp) {
            $object->setSlug();
        }
    }

    /** For Relationship */

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
