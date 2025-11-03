<?php

declare(strict_types=1);

namespace App\Trait\Entity;

use App\Entity\GarageApp;
use App\Entity\GarageStatMax;
use App\Entity\GarageStatMin;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;

trait GarageStatTrait
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $speed = 0;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $acceleration = 0;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $handling = 0;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $nitro = 0;

    #[ORM\Column(type: 'float', length: 6, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $average = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

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

        if ($total != 0) {
            $this->average = round(($total / 4), 2);
        } else {
            $this->average = 0;
        }

        return $this;
    }

    public function getGarage(): ?GarageApp
    {
        return $this->garage;
    }

    public function setGarage(?GarageApp $garage): static
    {
        $this->garage = $garage;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageStatMax or $object instanceof GarageStatMin) {
            // Set Average
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
        }
    }

    #[ORM\PostUpdate]
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageStatMax) {
            // Set Average
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
            $args->getObjectManager()->getRepository(GarageStatMax::class)->save($object, true);
        }
        if ($object instanceof GarageStatMin) {
            // Set Average
            $object->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
            $args->getObjectManager()->getRepository(GarageStatMin::class)->save($object, true);
        }
    }
}
