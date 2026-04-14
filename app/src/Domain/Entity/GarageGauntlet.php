<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\GarageGauntletRepository;
use App\Domain\Service\Entity\{GarageEntity, IdEntity};
use DH\Auditor\Provider\Doctrine\Auditing\Attribute as Audit;
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
#[Audit\Auditable]
class GarageGauntlet
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    #[Groups(['index', 'sheet'])]
    protected ?int $speed = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    #[Groups(['index', 'sheet'])]
    protected ?int $acceleration = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    #[Groups(['index', 'sheet'])]
    protected ?int $handling = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    #[Groups(['index', 'sheet'])]
    protected ?int $nitro = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    #[Groups(['index', 'sheet'])]
    protected ?int $mark = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 9, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9)]
    #[Groups(['index', 'sheet'])]
    protected ?int $division = null;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'gauntlet', cascade: ['persist'])]
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
}
