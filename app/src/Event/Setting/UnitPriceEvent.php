<?php

declare(strict_types=1);

namespace App\Event\Setting;

use App\Entity\SettingUnitPrice;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UnitPriceEvent
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {}

    /**
	 * Retourne le Unit-Price par défault de la Voiture
     *
     * @return SettingUnitPrice
     */
    public function getClass(): SettingUnitPrice
    {
        return $this->manager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => '6999984 || 99999 - 99999 - 99999 - 99999 - 999999 - 999999']);
    }
}
