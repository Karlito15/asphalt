<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageGauntletRepository;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageGauntletRepository::class)]
#[ORM\Table(name: 'garage_gauntlet')]
#[ORM\Index(name: 'garage_gauntlet_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageGauntlet
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    protected ?int $speed = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    protected ?int $acceleration = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    protected ?int $handling = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    protected ?int $nitro = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    protected ?int $mark = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    protected ?int $division = null;

    #[ORM\OneToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'gauntlet')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(?int $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getAcceleration(): ?int
    {
        return $this->acceleration;
    }

    public function setAcceleration(?int $acceleration): static
    {
        $this->acceleration = $acceleration;

        return $this;
    }

    public function getHandling(): ?int
    {
        return $this->handling;
    }

    public function setHandling(?int $handling): static
    {
        $this->handling = $handling;

        return $this;
    }

    public function getNitro(): ?int
    {
        return $this->nitro;
    }

    public function setNitro(?int $nitro): static
    {
        $this->nitro = $nitro;

        return $this;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(?int $mark): static
    {
        $this->mark = $mark;

        return $this;
    }

    public function getDivision(): ?int
    {
        return $this->division;
    }

    public function setDivision(?int $division): static
    {
        $this->division = $division;

        return $this;
    }
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageGauntlet) {
            // Set Mark
            $speed        = $object->getGarage()->getStatMax()->getValues()['speed'];
            $acceleration = $object->getGarage()->getStatMax()->getValues()['acceleration'];
            $handling     = $object->getGarage()->getStatMax()->getValues()['handling'];
            $nitro        = $object->getGarage()->getStatMax()->getValues()['nitro'];
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

    protected function calculateSpeed(float $value): int
    {
        return match (true) {
            $value <= 300 => 9,
            (300 > $value AND $value <= 350) => 3,
            (350 > $value AND $value <= 400) => 2,
            $value > 400 => 1,
        };
    }

    protected function calculateAcceleration(float $value): int
    {
        return match (true) {
            $value <= 80 => 9,
            (80 > $value AND $value <= 83) => 3,
            (83 > $value AND $value <= 86) => 2,
            $value > 86 => 1,
        };
    }

    protected function calculateHandling(float $value): int
    {
        return match (true) {
            $value <= 40 => 9,
            (40 > $value AND $value <= 60) => 3,
            (60 > $value AND $value <= 80) => 2,
            $value > 80 => 1,
        };
    }

    protected function calculateNitro(float $value): int
    {
        return match (true) {
            $value <= 45 => 9,
            (45 > $value AND $value <= 60) => 3,
            (60 > $value AND $value <= 75) => 2,
            $value > 75 => 1,
        };
    }

    protected function calculateAverage(int $speed, int $acceleration, int $handling, int $nitro): float
    {
        $average = ($speed + $acceleration + $handling + $nitro / 4);

        return floor($average);
    }
}
