<?php

namespace App\Service\Entities;

use App\Entity\SettingUnitPrice;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

trait SettingUnitPriceService
{
    public function setSlug(): static
    {
        /** Total Value */
        $total  =
            $this->getlevel01() + $this->getlevel02() + $this->getlevel03() + $this->getlevel04() + $this->getlevel05() + $this->getlevel06() + $this->getlevel07() +
            $this->getlevel08() + $this->getlevel09() + $this->getlevel10() + $this->getlevel11() + $this->getlevel12() + $this->getlevel13() +
            $this->getCommon() + $this->getRare() + $this->getEpic()
        ;

        $string =
            str_pad($total, 7, 0, STR_PAD_LEFT) . ' || ' .
            str_pad($this->getlevel01(), 5, 0, STR_PAD_LEFT) . ' - ' .
            str_pad($this->getlevel02(), 5, 0, STR_PAD_LEFT) . ' - ' .
            str_pad($this->getlevel03(), 5, 0, STR_PAD_LEFT) . ' - ' .
            str_pad($this->getcommon(), 5, 0, STR_PAD_LEFT) . ' - ' .
            str_pad($this->getrare(), 6, 0, STR_PAD_LEFT) . ' - ' .
            str_pad($this->getepic(), 6, 0, STR_PAD_LEFT)
        ;

        $this->slug = $string;

        return $this;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var SettingUnitPrice $object */
        $object = $args->getObject();
        if ($object instanceof SettingUnitPrice) {
            // Set Slug
            $object->setSlug();
        }
    }
}
