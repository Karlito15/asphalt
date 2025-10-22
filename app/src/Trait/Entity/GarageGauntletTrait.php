<?php

declare(strict_types=1);

namespace App\Trait\Entity;

use App\Entity\GarageGauntlet;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

trait GarageGauntletTrait
{

    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageGauntlet) {
            // Set Mark
            $speed = $object->getGarage()->getStatMax()->getValues()['speed'];
            $acceleration = $object->getGarage()->getStatMax()->getValues()['acceleration'];
            $handling = $object->getGarage()->getStatMax()->getValues()['handling'];
            $nitro = $object->getGarage()->getStatMax()->getValues()['nitro'];
        }
    }

    #[ORM\PostUpdate]
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageGauntlet) {
            // Set Mark
        }
    }

    private function calculateSpeed(float $value): int
    {
        return match (true) {
            $value <= 300 => 9,
            (300 > $value AND $value <= 350) => 3,
            (350 > $value AND $value <= 400) => 2,
            $value > 400 => 1,
        };
    }

    private function calculateAcceleration(float $value): int
    {
        return match (true) {
            $value <= 80 => 9,
            (80 > $value AND $value <= 83) => 3,
            (83 > $value AND $value <= 86) => 2,
            $value > 86 => 1,
        };
    }

    private function calculateHandling(float $value): int
    {
        return match (true) {
            $value <= 40 => 9,
            (40 > $value AND $value <= 60) => 3,
            (60 > $value AND $value <= 80) => 2,
            $value > 80 => 1,
        };
    }

    private function calculateNitro(float $value): int
    {
        return match (true) {
            $value <= 45 => 9,
            (45 > $value AND $value <= 60) => 3,
            (60 > $value AND $value <= 75) => 2,
            $value > 75 => 1,
        };
    }

    private function calculateAverage(int $speed, int $acceleration, int $handling, int $nitro): float
    {
        $average = ($speed + $acceleration + $handling + $nitro / 4);

        return floor($average);
    }
}
