<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageStatusRepository;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageStatusRepository::class)]
#[ORM\Table(name: 'garage_status')]
#[ORM\Index(name: 'garage_status_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageStatus
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
    #[Groups(['status'])]
    protected bool $evo = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['garage', 'status'])]
    protected bool $unblock = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['garage', 'status'])]
    protected bool $gold = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['status'])]
    protected bool $toUnblock = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['status'])]
    protected bool $toGold = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['status'])]
    protected bool $fullUpgradeLevel = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['status'])]
    protected bool $toUpgradeLevel = false;

    #[ORM\OneToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'status')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;

    public function isEvo(): ?bool
    {
        return $this->evo;
    }

    public function setEvo(bool $evo): static
    {
        $this->evo = $evo;

        return $this;
    }

    public function isUnblock(): ?bool
    {
        return $this->unblock;
    }

    public function setUnblock(bool $unblock): static
    {
        $this->unblock = $unblock;

        return $this;
    }

    public function isGold(): ?bool
    {
        return $this->gold;
    }

    public function setGold(bool $gold): static
    {
        $this->gold = $gold;

        return $this;
    }

    public function isToUnblock(): ?bool
    {
        return $this->toUnblock;
    }

    public function setToUnblock(bool $toUnblock): static
    {
        $this->toUnblock = $toUnblock;

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

    public function isFullUpgradeLevel(): ?bool
    {
        return $this->fullUpgradeLevel;
    }

    public function setFullUpgradeLevel(bool $fullUpgradeLevel): static
    {
        $this->fullUpgradeLevel = $fullUpgradeLevel;

        return $this;
    }

    public function isToUpgradeLevel(): ?bool
    {
        return $this->toUpgradeLevel;
    }

    public function setToUpgradeLevel(bool $toUpgradeLevel): static
    {
        $this->toUpgradeLevel = $toUpgradeLevel;

        return $this;
    }
}
