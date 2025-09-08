<?php

namespace App\Entity;

use App\Repository\GarageStatMinRepository;
use App\Service\Entities\GarageStatService;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageStatMinRepository::class)]
#[ORM\Table(name: 'garage_stat_min')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'name_idx', columns: ['id'])]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
//#[UniqueEntity(fields: ['label', 'value'], ignoreNull: 'value')]
class GarageStatMin
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use GarageStatService;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(type: 'float', nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $speed = 0;

    #[ORM\Column(type: 'float', nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $acceleration = 0;

    #[ORM\Column(type: 'float', nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $handly = 0;

    #[ORM\Column(type: 'float', nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $nitro = 0;

    #[ORM\Column(type: 'float', nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private float $average = 0;

    #[ORM\ManyToOne(targetEntity: AppGarage::class, cascade: ['persist', 'remove'], inversedBy: 'statMin')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    private AppGarage $garage;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function __toString() : string
    {
        return $this->getGarage();
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

    public function getHandly(): ?float
    {
        return $this->handly;
    }

    public function setHandly(float $handly): static
    {
        $this->handly = $handly;

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

    public function getGarage(): ?AppGarage
    {
        return $this->garage;
    }

    public function setGarage(?AppGarage $garage): static
    {
        $this->garage = $garage;

        return $this;
    }
}
