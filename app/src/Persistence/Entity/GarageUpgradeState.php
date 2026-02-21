<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageUpgradeStateRepository;
use App\Toolbox\Abstract\UpgradeAbstract;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageUpgradeStateRepository::class)]
#[ORM\Table(name: 'garage_upgrade_state')]
#[ORM\Index(name: 'garage_upgrade_state_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageUpgradeState extends UpgradeAbstract
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullSpeed = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $toInstallSpeed = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullAcceleration = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $toInstallAcceleration = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullHandling = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $toInstallHandling = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullNitro = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $toInstallNitro = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullCommon = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $toInstallCommon = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullRare = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $toInstallRare = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullEpic = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    protected bool $toInstallEpic = false;

    #[ORM\OneToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'upgradeState')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;

    public function isFullUpgradeSpeed(): ?bool
    {
        return $this->fullSpeed;
    }

    public function setFullUpgradeSpeed(bool $fullSpeed): static
    {
        $this->fullSpeed = $fullSpeed;

        return $this;
    }

    public function isToInstallSpeed(): ?bool
    {
        return $this->toInstallSpeed;
    }

    public function setToInstallSpeed(bool $toInstallSpeed): static
    {
        $this->toInstallSpeed = $toInstallSpeed;

        return $this;
    }

    public function isFullUpgradeAcceleration(): ?bool
    {
        return $this->fullAcceleration;
    }

    public function setFullUpgradeAcceleration(bool $fullAcceleration): static
    {
        $this->fullAcceleration = $fullAcceleration;

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

    public function isFullUpgradeHandling(): ?bool
    {
        return $this->fullHandling;
    }

    public function setFullUpgradeHandling(bool $fullHandling): static
    {
        $this->fullHandling = $fullHandling;

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

    public function isFullUpgradeNitro(): ?bool
    {
        return $this->fullNitro;
    }

    public function setFullUpgradeNitro(bool $fullNitro): static
    {
        $this->fullNitro = $fullNitro;

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

    public function isFullUpgradeCommon(): ?bool
    {
        return $this->fullCommon;
    }

    public function setFullUpgradeCommon(bool $fullCommon): static
    {
        $this->fullCommon = $fullCommon;

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

    public function isFullUpgradeRare(): ?bool
    {
        return $this->fullRare;
    }

    public function setFullUpgradeRare(bool $fullRare): static
    {
        $this->fullRare = $fullRare;

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

    public function isFullUpgradeEpic(): ?bool
    {
        return $this->fullEpic;
    }

    public function setFullUpgradeEpic(bool $fullEpic): static
    {
        $this->fullEpic = $fullEpic;

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
}
