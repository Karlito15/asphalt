<?php

declare(strict_types=1);

namespace App\Trait\Entity;

use App\Entity\SettingUnitPrice;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

trait SettingUnitPriceTrait
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
            str_pad((string) $total, 7, '0', STR_PAD_LEFT) . ' || ' .
            str_pad((string) $this->getlevel01(), 5, '0', STR_PAD_LEFT) . ' - ' .
            str_pad((string) $this->getlevel02(), 5, '0', STR_PAD_LEFT) . ' - ' .
            str_pad((string) $this->getlevel03(), 5, '0', STR_PAD_LEFT) . ' - ' .
            str_pad((string) $this->getcommon(), 5, '0', STR_PAD_LEFT) . ' - ' .
            str_pad((string) $this->getrare(), 6, '0', STR_PAD_LEFT) . ' - ' .
            str_pad((string) $this->getepic(), 6, '0', STR_PAD_LEFT)
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
