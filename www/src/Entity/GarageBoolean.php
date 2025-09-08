<?php

namespace App\Entity;

use App\Repository\GarageBooleanRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageBooleanRepository::class)]
#[ORM\Table(name: 'garage_boolean')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'name_idx', columns: ['id'])]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
//#[UniqueEntity(fields: ['label', 'value'], ignoreNull: 'value')]
class GarageBoolean
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(nullable: false, options: ['default' => true])]
    private bool $locked = true;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $fullBlueprint = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $gold = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $toUnlock = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $toUpgrade = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $toGold = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $installSpeed = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $fullSpeed = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $installAcceleration = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $fullAcceleration = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $installHandly = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $fullHandly = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $installNitro = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $fullNitro = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $installCommon = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $fullCommon = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $installRare = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $fullRare = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $installEpic = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $fullEpic = false;

    #[ORM\ManyToOne(targetEntity: AppGarage::class, cascade: ['persist', 'remove'], fetch: 'EAGER', inversedBy: 'boolean')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    private AppGarage $garage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString() : string
    {
        return $this->getGarage();
    }

    public function isLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): static
    {
        $this->locked = $locked;

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

    public function isGold(): ?bool
    {
        return $this->gold;
    }

    public function setGold(bool $gold): static
    {
        $this->gold = $gold;

        return $this;
    }

    public function isToUnlock(): ?bool
    {
        return $this->toUnlock;
    }

    public function setToUnlock(bool $toUnlock): static
    {
        $this->toUnlock = $toUnlock;

        return $this;
    }

    public function isToUpgrade(): ?bool
    {
        return $this->toUpgrade;
    }

    public function setToUpgrade(bool $toUpgrade): static
    {
        $this->toUpgrade = $toUpgrade;

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

    public function isInstallSpeed(): ?bool
    {
        return $this->installSpeed;
    }

    public function setInstallSpeed(bool $installSpeed): static
    {
        $this->installSpeed = $installSpeed;

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

    public function isInstallAcceleration(): ?bool
    {
        return $this->installAcceleration;
    }

    public function setInstallAcceleration(bool $installAcceleration): static
    {
        $this->installAcceleration = $installAcceleration;

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

    public function isInstallHandly(): ?bool
    {
        return $this->installHandly;
    }

    public function setInstallHandly(bool $installHandly): static
    {
        $this->installHandly = $installHandly;

        return $this;
    }

    public function isFullHandly(): ?bool
    {
        return $this->fullHandly;
    }

    public function setFullHandly(bool $fullHandly): static
    {
        $this->fullHandly = $fullHandly;

        return $this;
    }

    public function isInstallNitro(): ?bool
    {
        return $this->installNitro;
    }

    public function setInstallNitro(bool $installNitro): static
    {
        $this->installNitro = $installNitro;

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

    public function isInstallCommon(): ?bool
    {
        return $this->installCommon;
    }

    public function setInstallCommon(bool $installCommon): static
    {
        $this->installCommon = $installCommon;

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

    public function isInstallRare(): ?bool
    {
        return $this->installRare;
    }

    public function setInstallRare(bool $installRare): static
    {
        $this->installRare = $installRare;

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

    public function isInstallEpic(): ?bool
    {
        return $this->installEpic;
    }

    public function setInstallEpic(bool $installEpic): static
    {
        $this->installEpic = $installEpic;

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
