<?php

declare(strict_types=1);

namespace App\Trait\Entity;

use App\Entity\GarageApp;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait GarageAppTrait
{
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
     * Order : 1
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
     * Order : 2
     *
     * @param PostPersistEventArgs $args
     * @return void
     */
    #[ORM\PostPersist]
    #[NoReturn]
    public function postPersist(PostPersistEventArgs $args): void
    {
        /* @var GarageApp $object */
        $object = $args->getObject();
        // dump('postPersist', $object);
    }

    /**
     * Met à jour le slug si le model change
     * Order : 3
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

    /**
     * Order : 4
     *
     * @param PostUpdateEventArgs $args
     * @return void
     */
    #[ORM\PostUpdate]
    #[NoReturn]
    public function postUpdate(PostUpdateEventArgs $args): void
    {
        /* @var GarageApp $object */
        $object = $args->getObject();
        // dump('postUpdate', $object);
    }
}
