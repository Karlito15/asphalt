<?php

declare(strict_types=1);

namespace App\Service\Abstract;

use App\Persistence\Entity\GarageStatActual;
use App\Persistence\Entity\GarageStatMax;
use App\Persistence\Entity\GarageStatMin;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class StatAbstract
{
    use IdEntity, GarageEntity;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Groups(['index', 'sheet'])]
    protected float $speed = 0;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Groups(['index', 'sheet'])]
    protected float $acceleration = 0;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Groups(['index', 'sheet'])]
    protected float $handling = 0;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Groups(['index', 'sheet'])]
    protected float $nitro = 0;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Groups(['index', 'sheet'])]
    protected float $average = 0;

    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    public function setSpeed(float $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getAcceleration(): ?float
    {
        return $this->acceleration;
    }

    public function setAcceleration(float $acceleration): static
    {
        $this->acceleration = $acceleration;

        return $this;
    }

    public function getHandling(): ?float
    {
        return $this->handling;
    }

    public function setHandling(float $handling): static
    {
        $this->handling = $handling;

        return $this;
    }

    public function getNitro(): ?float
    {
        return $this->nitro;
    }

    public function setNitro(float $nitro): static
    {
        $this->nitro = $nitro;

        return $this;
    }

    public function getAverage(): ?float
    {
        return $this->average;
    }

    /**
     * Calcule la moyenne des Stats pour une voiture
     *
     * @param float|null $speed
     * @param float|null $acceleration
     * @param float|null $handling
     * @param float|null $nitro
     * @return $this
     */
    public function setAverage(?float $speed, ?float $acceleration, ?float $handling, ?float $nitro): static
    {
        $total = $speed + $acceleration + $handling + $nitro;

        $this->average = round(($total / 4), 2);

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        // Set Average
        if ($object instanceof GarageStatActual or
            $object instanceof GarageStatMax or
            $object instanceof GarageStatMin
        ) {
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
        }
    }

    #[ORM\PostUpdate]
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        // Set Average
        if ($object instanceof GarageStatActual) {
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
            $args->getObjectManager()->getRepository(GarageStatActual::class)->save($object, true);
        }
        if ($object instanceof GarageStatMax) {
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
            $args->getObjectManager()->getRepository(GarageStatMax::class)->save($object, true);
        }
        if ($object instanceof GarageStatMin) {
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
            $args->getObjectManager()->getRepository(GarageStatMin::class)->save($object, true);
        }
    }
}
