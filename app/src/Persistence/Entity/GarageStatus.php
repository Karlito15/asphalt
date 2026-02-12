<?php

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageStatusRepository;
use App\Persistence\Trait\Entity\GarageAppableEntity;
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
    use GarageAppableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    private ?int $id = null;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['status'])]
    private bool $evo = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['garage', 'status'])]
    private bool $unblock = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['status'])]
    private bool $toUnblock = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['garage', 'status'])]
    private bool $gold = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['status'])]
    private bool $toGold = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullUpgradeLevel = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['status'])]
    private bool $toUpgradeLevel = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullBlueprintStar1 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullBlueprintStar2 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullBlueprintStar3 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullBlueprintStar4 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullBlueprintStar5 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullBlueprintStar6 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullUpgradeSpeed = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $toInstallUpgradeSpeed = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullUpgradeAcceleration = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $toInstallUpgradeAcceleration = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullUpgradeHandling = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $toInstallUpgradeHandling = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullUpgradeNitro = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $toInstallUpgradeNitro = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullUpgradeCommon = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $toInstallUpgradeCommon = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullUpgradeRare = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $toInstallUpgradeRare = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $fullUpgradeEpic = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    private bool $toInstallUpgradeEpic = false;

    #[ORM\ManyToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'status')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    private GarageApp $garage;

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function isToUnblock(): ?bool
    {
        return $this->toUnblock;
    }

    public function setToUnblock(bool $toUnblock): static
    {
        $this->toUnblock = $toUnblock;

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

    public function isFullBlueprintStar1(): ?bool
    {
        return $this->fullBlueprintStar1;
    }

    public function setFullBlueprintStar1(bool $fullBlueprintStar1): static
    {
        $this->fullBlueprintStar1 = $fullBlueprintStar1;

        return $this;
    }

    public function isFullBlueprintStar2(): ?bool
    {
        return $this->fullBlueprintStar2;
    }

    public function setFullBlueprintStar2(bool $fullBlueprintStar2): static
    {
        $this->fullBlueprintStar2 = $fullBlueprintStar2;

        return $this;
    }

    public function isFullBlueprintStar3(): ?bool
    {
        return $this->fullBlueprintStar3;
    }

    public function setFullBlueprintStar3(bool $fullBlueprintStar3): static
    {
        $this->fullBlueprintStar3 = $fullBlueprintStar3;

        return $this;
    }

    public function isFullBlueprintStar4(): ?bool
    {
        return $this->fullBlueprintStar4;
    }

    public function setFullBlueprintStar4(bool $fullBlueprintStar4): static
    {
        $this->fullBlueprintStar4 = $fullBlueprintStar4;

        return $this;
    }

    public function isFullBlueprintStar5(): ?bool
    {
        return $this->fullBlueprintStar5;
    }

    public function setFullBlueprintStar5(bool $fullBlueprintStar5): static
    {
        $this->fullBlueprintStar5 = $fullBlueprintStar5;

        return $this;
    }

    public function isFullBlueprintStar6(): ?bool
    {
        return $this->fullBlueprintStar6;
    }

    public function setFullBlueprintStar6(bool $fullBlueprintStar6): static
    {
        $this->fullBlueprintStar6 = $fullBlueprintStar6;

        return $this;
    }

    public function isFullUpgradeSpeed(): ?bool
    {
        return $this->fullUpgradeSpeed;
    }

    public function setFullUpgradeSpeed(bool $fullUpgradeSpeed): static
    {
        $this->fullUpgradeSpeed = $fullUpgradeSpeed;

        return $this;
    }

    public function isToInstallUpgradeSpeed(): ?bool
    {
        return $this->toInstallUpgradeSpeed;
    }

    public function setToInstallUpgradeSpeed(bool $toInstallUpgradeSpeed): static
    {
        $this->toInstallUpgradeSpeed = $toInstallUpgradeSpeed;

        return $this;
    }

    public function isFullUpgradeAcceleration(): ?bool
    {
        return $this->fullUpgradeAcceleration;
    }

    public function setFullUpgradeAcceleration(bool $fullUpgradeAcceleration): static
    {
        $this->fullUpgradeAcceleration = $fullUpgradeAcceleration;

        return $this;
    }

    public function isToInstallUpgradeAcceleration(): ?bool
    {
        return $this->toInstallUpgradeAcceleration;
    }

    public function setToInstallUpgradeAcceleration(bool $toInstallUpgradeAcceleration): static
    {
        $this->toInstallUpgradeAcceleration = $toInstallUpgradeAcceleration;

        return $this;
    }

    public function isFullUpgradeHandling(): ?bool
    {
        return $this->fullUpgradeHandling;
    }

    public function setFullUpgradeHandling(bool $fullUpgradeHandling): static
    {
        $this->fullUpgradeHandling = $fullUpgradeHandling;

        return $this;
    }

    public function isToInstallUpgradeHandling(): ?bool
    {
        return $this->toInstallUpgradeHandling;
    }

    public function setToInstallUpgradeHandling(bool $toInstallUpgradeHandling): static
    {
        $this->toInstallUpgradeHandling = $toInstallUpgradeHandling;

        return $this;
    }

    public function isFullUpgradeNitro(): ?bool
    {
        return $this->fullUpgradeNitro;
    }

    public function setFullUpgradeNitro(bool $fullUpgradeNitro): static
    {
        $this->fullUpgradeNitro = $fullUpgradeNitro;

        return $this;
    }

    public function isToInstallUpgradeNitro(): ?bool
    {
        return $this->toInstallUpgradeNitro;
    }

    public function setToInstallUpgradeNitro(bool $toInstallUpgradeNitro): static
    {
        $this->toInstallUpgradeNitro = $toInstallUpgradeNitro;

        return $this;
    }

    public function isFullUpgradeCommon(): ?bool
    {
        return $this->fullUpgradeCommon;
    }

    public function setFullUpgradeCommon(bool $fullUpgradeCommon): static
    {
        $this->fullUpgradeCommon = $fullUpgradeCommon;

        return $this;
    }

    public function isToInstallUpgradeCommon(): ?bool
    {
        return $this->toInstallUpgradeCommon;
    }

    public function setToInstallUpgradeCommon(bool $toInstallUpgradeCommon): static
    {
        $this->toInstallUpgradeCommon = $toInstallUpgradeCommon;

        return $this;
    }

    public function isFullUpgradeRare(): ?bool
    {
        return $this->fullUpgradeRare;
    }

    public function setFullUpgradeRare(bool $fullUpgradeRare): static
    {
        $this->fullUpgradeRare = $fullUpgradeRare;

        return $this;
    }

    public function isToInstallUpgradeRare(): ?bool
    {
        return $this->toInstallUpgradeRare;
    }

    public function setToInstallUpgradeRare(bool $toInstallUpgradeRare): static
    {
        $this->toInstallUpgradeRare = $toInstallUpgradeRare;

        return $this;
    }

    public function isFullUpgradeEpic(): ?bool
    {
        return $this->fullUpgradeEpic;
    }

    public function setFullUpgradeEpic(bool $fullUpgradeEpic): static
    {
        $this->fullUpgradeEpic = $fullUpgradeEpic;

        return $this;
    }

    public function isToInstallUpgradeEpic(): ?bool
    {
        return $this->toInstallUpgradeEpic;
    }

    public function setToInstallUpgradeEpic(bool $toInstallUpgradeEpic): static
    {
        $this->toInstallUpgradeEpic = $toInstallUpgradeEpic;

        return $this;
    }
}
