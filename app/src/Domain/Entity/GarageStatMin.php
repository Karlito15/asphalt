<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\GarageStatMinRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageStatMinRepository::class)]
#[ORM\Table(name: 'garage_stat_min')]
#[ORM\Index(name: 'garage_stat_min_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageStatMin
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer'])]
    #[Groups(['index'])]
    protected ?int $id = null;

    #[ORM\Column(type: 'float', length: 6, precision: 2, nullable: false)]
    #[Groups(['index', 'migration'])]
    protected float $speed = 0;

    #[ORM\Column(type: 'float', length: 6, precision: 2, nullable: false)]
    #[Groups(['index', 'migration'])]
    protected float $acceleration = 0;

    #[ORM\Column(type: 'float', length: 6, precision: 2, nullable: false)]
    #[Groups(['index', 'migration'])]
    protected float $handling = 0;

    #[ORM\Column(type: 'float', length: 6, precision: 2, nullable: false)]
    #[Groups(['index', 'migration'])]
    protected float $nitro = 0;

    #[ORM\Column(type: 'float', length: 6, precision: 2, nullable: false)]
    #[Groups(['index', 'migration'])]
    protected float $average = 0;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'statMin', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['filter'])]
    protected GarageApp $garage;

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

        $this->average = round(($total / 4), 2);

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

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $args->getObject()->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PostUpdate]
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $args->getObject()->setAverage($this->getSpeed(), $this->getAcceleration(), $this->getHandling(), $this->getNitro());
        $args->getObjectManager()->getRepository(GarageStatMin::class)->save($args->getObject(), true);
    }
}
