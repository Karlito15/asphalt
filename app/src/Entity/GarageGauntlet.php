<?php

namespace App\Entity;

use App\Repository\GarageGauntletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageGauntletRepository::class)]
#[ORM\Table(name: 'garage_gauntlet')]
#[ORM\Index(name: 'garage_gauntlet_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageGauntlet
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
//    use GarageGauntletTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    private ?int $speed = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    private ?int $acceleration = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    private ?int $handling = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    private ?int $nitro = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    private ?int $calculateMark = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    private ?int $tempMark = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    private ?int $finalMark = null;

    #[ORM\ManyToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'gauntlet')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    private GarageApp $garage;

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getCalculateMark(): ?int
    {
        return $this->calculateMark;
    }

    public function setCalculateMark(?int $calculateMark): static
    {
        $this->calculateMark = $calculateMark;

        return $this;
    }

    public function getTempMark(): ?int
    {
        return $this->tempMark;
    }

    public function setTempMark(?int $tempMark): static
    {
        $this->tempMark = $tempMark;

        return $this;
    }

    public function getFinalMark(): ?int
    {
        return $this->finalMark;
    }

    public function setFinalMark(?int $finalMark): static
    {
        $this->finalMark = $finalMark;

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
}
