<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\GarageGauntletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageGauntletRepository::class)]
#[ORM\Table(name: 'garage_gauntlet')]
#[ORM\Index(name: 'garage_gauntlet_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageGauntlet
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer'])]
    #[Groups(['index'])]
    protected ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected ?int $speed = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected ?int $acceleration = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected ?int $handling = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected ?int $nitro = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected ?int $mark = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected ?int $division = null;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'gauntlet', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['filter'])]
    protected GarageApp $garage;

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
