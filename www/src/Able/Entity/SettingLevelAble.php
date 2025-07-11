<?php

declare(strict_types=1);

namespace App\Able\Entity;

use App\Entity\SettingLevel;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

trait SettingLevelAble
{
    public function setSlug(): static
    {
        $this->slug =
            $this->level . ' || ' .
            str_pad((string) $this->common, 2, '0', STR_PAD_LEFT) . ' - ' .
            str_pad((string) $this->rare, 2, '0', STR_PAD_LEFT) . ' - ' .
            str_pad((string) $this->epic, 2, '0', STR_PAD_LEFT)
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
        /* @var SettingLevel $object */
        $object = $args->getObject();
        if ($object instanceof SettingLevel) {
            // Set Slug
            $object->setSlug();
        }
    }
}
