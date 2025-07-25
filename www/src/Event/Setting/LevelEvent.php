<?php

declare(strict_types=1);

namespace App\Event\Setting;

use App\Entity\SettingLevel;
use Doctrine\ORM\EntityManagerInterface;

final readonly class LevelEvent
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    /**
	 * Retourne le Level par défault de la Voiture
     *
     * @return SettingLevel
     */
    public function getLevel(): SettingLevel
    {
        return $this->entityManager->getRepository(SettingLevel::class)->findOneBy(['slug' => '99 || 99 - 99 - 99']);
    }
}
