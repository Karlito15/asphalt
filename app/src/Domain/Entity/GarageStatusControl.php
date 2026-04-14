<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\GarageStatusControlRepository;
use App\Domain\Service\Entity\{GarageEntity, IdEntity};
use DH\Auditor\Provider\Doctrine\Auditing\Attribute as Audit;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageStatusControlRepository::class)]
#[ORM\Table(name: 'garage_status_control')]
#[ORM\Index(name: 'garage_status_control_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[Audit\Auditable]
class GarageStatusControl
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallSpeed = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullSpeed = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallAcceleration = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullAcceleration = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallHandling = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullHandling = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallNitro = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullNitro = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallCommon = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullCommon = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallRare = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullRare = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallEpic = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullEpic = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullStar1 = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullStar2 = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullStar3 = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullStar4 = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullStar5 = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullStar6 = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullBlueprint = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallUpgrade = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullUpgrade = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toInstallImport = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullImport = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toGold = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $fullEvo = false;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'statusControl', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['filter'])]
    protected GarageApp $garage;

    public function isToInstallSpeed(): ?bool
    {
        return $this->toInstallSpeed;
    }

    public function setToInstallSpeed(bool $toInstallSpeed): static
    {
        $this->toInstallSpeed = $toInstallSpeed;

        return $this;
    }

    public function isFullSpeed(): ?bool
    {
        return $this->fullSpeed;
    }

    public function setFullSpeed(bool $fullSpeed): static
    {
        $this->fullSpeed = $fullSpeed;

        return $this;
    }

    public function isToInstallAcceleration(): ?bool
    {
        return $this->toInstallAcceleration;
    }

    public function setToInstallAcceleration(bool $toInstallAcceleration): static
    {
        $this->toInstallAcceleration = $toInstallAcceleration;

        return $this;
    }

    public function isFullAcceleration(): ?bool
    {
        return $this->fullAcceleration;
    }

    public function setFullAcceleration(bool $fullAcceleration): static
    {
        $this->fullAcceleration = $fullAcceleration;

        return $this;
    }

    public function isToInstallHandling(): ?bool
    {
        return $this->toInstallHandling;
    }

    public function setToInstallHandling(bool $toInstallHandling): static
    {
        $this->toInstallHandling = $toInstallHandling;

        return $this;
    }

    public function isFullHandling(): ?bool
    {
        return $this->fullHandling;
    }

    public function setFullHandling(bool $fullHandling): static
    {
        $this->fullHandling = $fullHandling;

        return $this;
    }

    public function isToInstallNitro(): ?bool
    {
        return $this->toInstallNitro;
    }

    public function setToInstallNitro(bool $toInstallNitro): static
    {
        $this->toInstallNitro = $toInstallNitro;

        return $this;
    }

    public function isFullNitro(): ?bool
    {
        return $this->fullNitro;
    }

    public function setFullNitro(bool $fullNitro): static
    {
        $this->fullNitro = $fullNitro;

        return $this;
    }

    public function isToInstallCommon(): ?bool
    {
        return $this->toInstallCommon;
    }

    public function setToInstallCommon(bool $toInstallCommon): static
    {
        $this->toInstallCommon = $toInstallCommon;

        return $this;
    }

    public function isFullCommon(): ?bool
    {
        return $this->fullCommon;
    }

    public function setFullCommon(bool $fullCommon): static
    {
        $this->fullCommon = $fullCommon;

        return $this;
    }

    public function isToInstallRare(): ?bool
    {
        return $this->toInstallRare;
    }

    public function setToInstallRare(bool $toInstallRare): static
    {
        $this->toInstallRare = $toInstallRare;

        return $this;
    }

    public function isFullRare(): ?bool
    {
        return $this->fullRare;
    }

    public function setFullRare(bool $fullRare): static
    {
        $this->fullRare = $fullRare;

        return $this;
    }

    public function isToInstallEpic(): ?bool
    {
        return $this->toInstallEpic;
    }

    public function setToInstallEpic(bool $toInstallEpic): static
    {
        $this->toInstallEpic = $toInstallEpic;

        return $this;
    }

    public function isFullEpic(): ?bool
    {
        return $this->fullEpic;
    }

    public function setFullEpic(bool $fullEpic): static
    {
        $this->fullEpic = $fullEpic;

        return $this;
    }

    public function isFullStar1(): ?bool
    {
        return $this->fullStar1;
    }

    public function setFullStar1(bool $fullStar1): static
    {
        $this->fullStar1 = $fullStar1;

        return $this;
    }

    public function isFullStar2(): ?bool
    {
        return $this->fullStar2;
    }

    public function setFullStar2(bool $fullStar2): static
    {
        $this->fullStar2 = $fullStar2;

        return $this;
    }

    public function isFullStar3(): ?bool
    {
        return $this->fullStar3;
    }

    public function setFullStar3(bool $fullStar3): static
    {
        $this->fullStar3 = $fullStar3;

        return $this;
    }

    public function isFullStar4(): ?bool
    {
        return $this->fullStar4;
    }

    public function setFullStar4(bool $fullStar4): static
    {
        $this->fullStar4 = $fullStar4;

        return $this;
    }

    public function isFullStar5(): ?bool
    {
        return $this->fullStar5;
    }

    public function setFullStar5(bool $fullStar5): static
    {
        $this->fullStar5 = $fullStar5;

        return $this;
    }

    public function isFullStar6(): ?bool
    {
        return $this->fullStar6;
    }

    public function setFullStar6(bool $fullStar6): static
    {
        $this->fullStar6 = $fullStar6;

        return $this;
    }

    public function isFullBlueprint(): ?bool
    {
        return $this->fullBlueprint;
    }

    public function setFullBlueprint(bool $fullBlueprint): static
    {
        $this->fullBlueprint = $fullBlueprint;

        return $this;
    }

    public function isToInstallUpgrade(): ?bool
    {
        return $this->toInstallUpgrade;
    }

    public function setToInstallUpgrade(bool $toInstallUpgrade): static
    {
        $this->toInstallUpgrade = $toInstallUpgrade;

        return $this;
    }

    public function isFullUpgrade(): ?bool
    {
        return $this->fullUpgrade;
    }

    public function setFullUpgrade(bool $fullUpgrade): static
    {
        $this->fullUpgrade = $fullUpgrade;

        return $this;
    }

    public function isToInstallImport(): ?bool
    {
        return $this->toInstallImport;
    }

    public function setToInstallImport(bool $toInstallImport): static
    {
        $this->toInstallImport = $toInstallImport;

        return $this;
    }

    public function isFullImport(): ?bool
    {
        return $this->fullImport;
    }

    public function setFullImport(bool $fullImport): static
    {
        $this->fullImport = $fullImport;

        return $this;
    }

    public function isToGold(): ?bool
    {
        return $this->toGold;
    }

    public function setToGold(bool $toGold): static
    {
        $this->toGold = $toGold;

        return $this;
    }

    public function isFullEvo(): ?bool
    {
        return $this->fullEvo;
    }

    public function setFullEvo(bool $fullEvo): static
    {
        $this->fullEvo = $fullEvo;

        return $this;
    }
}
