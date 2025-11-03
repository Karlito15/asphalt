<?php

namespace App\Entity;

use App\Repository\GarageAppRepository;
use App\Trait\Entity\GarageAppTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageAppRepository::class)]
#[ORM\Table(name: 'garage_app')]
#[ORM\Index(name: 'garage_app_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity('slug')]
class GarageApp
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use GarageAppTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, length: 1, nullable: false, options: ['default' => 3, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Assert\Range(min: 3, max: 6)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $stars = 3;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $gameUpdate = 0;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 99, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Assert\Range(min: 1, max: 99)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $carOrder = 99;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 99, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Assert\Range(min: 1, max: 99)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $statOrder = 99;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 13)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level = 0;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 16,)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $epic = 0;

    #[ORM\Column(type: Types::STRING, length: 128, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 128)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private string $model;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    #[Assert\Length(min: 1, max: 255)]
    #[Gedmo\Versioned]
    private string $slug;

    #[ORM\OneToMany(targetEntity: GarageBlueprint::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    private Collection $blueprint;

    #[ORM\OneToMany(targetEntity: GarageGauntlet::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    private Collection $gauntlet;

    #[ORM\OneToMany(targetEntity: GarageRank::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    private Collection $rank;

    #[ORM\OneToMany(targetEntity: GarageStatActual::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    private Collection $statActual;

    #[ORM\OneToMany(targetEntity: GarageStatMax::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    private Collection $statMax;

    #[ORM\OneToMany(targetEntity: GarageStatMin::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    private Collection $statMin;

    #[ORM\OneToMany(targetEntity: GarageStatus::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    private Collection $status;

    #[ORM\OneToMany(targetEntity: GarageUpgrade::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    private Collection $upgrade;

    #[ORM\ManyToOne(targetEntity: SettingBlueprint::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingBlueprint::class)]
    private ?SettingBlueprint $settingBlueprint = null;

    #[ORM\ManyToOne(targetEntity: SettingBrand::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingBrand::class)]
    private ?SettingBrand $settingBrand = null;

    #[ORM\ManyToOne(targetEntity: SettingClass::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingClass::class)]
    private ?SettingClass $settingClass = null;

    #[ORM\ManyToOne(targetEntity: SettingLevel::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingLevel::class)]
    private ?SettingLevel $settingLevel = null;

    #[ORM\ManyToMany(targetEntity: SettingTag::class, mappedBy: 'garage')]
    private ?Collection $settingTag;

    #[ORM\ManyToOne(targetEntity: SettingUnitPrice::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingUnitPrice::class)]
    private ?SettingUnitPrice $settingUnitPrice = null;

    public function __construct()
    {
        $this->blueprint    = new ArrayCollection();
        $this->gauntlet     = new ArrayCollection();
        $this->rank         = new ArrayCollection();
        $this->statActual   = new ArrayCollection();
        $this->statMax      = new ArrayCollection();
        $this->statMin      = new ArrayCollection();
        $this->status       = new ArrayCollection();
        $this->upgrade      = new ArrayCollection();
        $this->settingTag   = new ArrayCollection();
    }

    public function __toString(): string
    {
//        return $this->getModel();
        return $this->getSlug();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(int $stars): static
    {
        $this->stars = $stars;

        return $this;
    }

    public function getGameUpdate(): ?int
    {
        return $this->gameUpdate;
    }

    public function setGameUpdate(int $gameUpdate): static
    {
        $this->gameUpdate = $gameUpdate;

        return $this;
    }

    public function getCarOrder(): ?int
    {
        return $this->carOrder;
    }

    public function setCarOrder(int $carOrder): static
    {
        $this->carOrder = $carOrder;

        return $this;
    }

    public function getStatOrder(): ?int
    {
        return $this->statOrder;
    }

    public function setStatOrder(int $statOrder): static
    {
        $this->statOrder = $statOrder;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getEpic(): ?int
    {
        return $this->epic;
    }

    public function setEpic(int $epic): static
    {
        $this->epic = $epic;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return Collection<int, GarageBlueprint>
     */
    public function getBlueprint(): Collection
    {
        return $this->blueprint;
    }

    public function addBlueprint(GarageBlueprint $blueprint): static
    {
        if (!$this->blueprint->contains($blueprint)) {
            $this->blueprint->add($blueprint);
            $blueprint->setGarage($this);
        }

        return $this;
    }

    public function removeBlueprint(GarageBlueprint $blueprint): static
    {
        if ($this->blueprint->removeElement($blueprint)) {
            // set the owning side to null (unless already changed)
            if ($blueprint->getGarage() === $this) {
                $blueprint->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GarageGauntlet>
     */
    public function getGauntlet(): Collection
    {
        return $this->gauntlet;
    }

    public function addGauntlet(GarageGauntlet $gauntlet): static
    {
        if (!$this->gauntlet->contains($gauntlet)) {
            $this->gauntlet->add($gauntlet);
            $gauntlet->setGarage($this);
        }

        return $this;
    }

    public function removeGauntlet(GarageGauntlet $gauntlet): static
    {
        if ($this->gauntlet->removeElement($gauntlet)) {
            // set the owning side to null (unless already changed)
            if ($gauntlet->getGarage() === $this) {
                $gauntlet->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GarageRank>
     */
    public function getRank(): Collection
    {
        return $this->rank;
    }

    public function addRank(GarageRank $rank): static
    {
        if (!$this->rank->contains($rank)) {
            $this->rank->add($rank);
            $rank->setGarage($this);
        }

        return $this;
    }

    public function removeRank(GarageRank $rank): static
    {
        if ($this->rank->removeElement($rank)) {
            // set the owning side to null (unless already changed)
            if ($rank->getGarage() === $this) {
                $rank->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GarageStatus>
     */
    public function getStatus(): Collection
    {
        return $this->status;
    }

    public function addStatus(GarageStatus $status): static
    {
        if (!$this->status->contains($status)) {
            $this->status->add($status);
            $status->setGarage($this);
        }

        return $this;
    }

    public function removeStatus(GarageStatus $status): static
    {
        if ($this->status->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getGarage() === $this) {
                $status->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GarageStatActual>
     */
    public function getStatActual(): Collection
    {
        return $this->statActual;
    }

    public function addStatActual(GarageStatActual $statActual): static
    {
        if (!$this->statActual->contains($statActual)) {
            $this->statActual->add($statActual);
            $statActual->setGarage($this);
        }

        return $this;
    }

    public function removeStatActual(GarageStatActual $statActual): static
    {
        if ($this->statActual->removeElement($statActual)) {
            // set the owning side to null (unless already changed)
            if ($statActual->getGarage() === $this) {
                $statActual->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GarageStatMax>
     */
    public function getStatMax(): Collection
    {
        return $this->statMax;
    }

    public function addStatMax(GarageStatMax $statMax): static
    {
        if (!$this->statMax->contains($statMax)) {
            $this->statMax->add($statMax);
            $statMax->setGarage($this);
        }

        return $this;
    }

    public function removeStatMax(GarageStatMax $statMax): static
    {
        if ($this->statMax->removeElement($statMax)) {
            // set the owning side to null (unless already changed)
            if ($statMax->getGarage() === $this) {
                $statMax->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GarageStatMin>
     */
    public function getStatMin(): Collection
    {
        return $this->statMin;
    }

    public function addStatMin(GarageStatMin $statMin): static
    {
        if (!$this->statMin->contains($statMin)) {
            $this->statMin->add($statMin);
            $statMin->setGarage($this);
        }

        return $this;
    }

    public function removeStatMin(GarageStatMin $statMin): static
    {
        if ($this->statMin->removeElement($statMin)) {
            // set the owning side to null (unless already changed)
            if ($statMin->getGarage() === $this) {
                $statMin->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GarageUpgrade>
     */
    public function getUpgrade(): Collection
    {
        return $this->upgrade;
    }

    public function addUpgrade(GarageUpgrade $upgrade): static
    {
        if (!$this->upgrade->contains($upgrade)) {
            $this->upgrade->add($upgrade);
            $upgrade->setGarage($this);
        }

        return $this;
    }

    public function removeUpgrade(GarageUpgrade $upgrade): static
    {
        if ($this->upgrade->removeElement($upgrade)) {
            // set the owning side to null (unless already changed)
            if ($upgrade->getGarage() === $this) {
                $upgrade->setGarage(null);
            }
        }

        return $this;
    }

    public function getSettingBlueprint(): ?SettingBlueprint
    {
        return $this->settingBlueprint;
    }

    public function setSettingBlueprint(?SettingBlueprint $settingBlueprint): static
    {
        $this->settingBlueprint = $settingBlueprint;

        return $this;
    }

    public function getSettingBrand(): ?SettingBrand
    {
        return $this->settingBrand;
    }

    public function setSettingBrand(?SettingBrand $settingBrand): static
    {
        $this->settingBrand = $settingBrand;

        return $this;
    }

    public function getSettingClass(): ?SettingClass
    {
        return $this->settingClass;
    }

    public function setSettingClass(?SettingClass $settingClass): static
    {
        $this->settingClass = $settingClass;

        return $this;
    }

    public function getSettingLevel(): ?SettingLevel
    {
        return $this->settingLevel;
    }

    public function setSettingLevel(?SettingLevel $settingLevel): static
    {
        $this->settingLevel = $settingLevel;

        return $this;
    }

    /**
     * @return Collection<int, SettingTag>
     */
    public function getSettingTag(): Collection
    {
        return $this->settingTag;
    }

    public function addSettingTag(SettingTag $settingTag): static
    {
        if (!$this->settingTag->contains($settingTag)) {
            $this->settingTag->add($settingTag);
            $settingTag->addGarage($this);
        }

        return $this;
    }

    public function removeSettingTag(SettingTag $settingTag): static
    {
        if ($this->settingTag->removeElement($settingTag)) {
            $settingTag->removeGarage($this);
        }

        return $this;
    }

    public function getSettingUnitPrice(): ?SettingUnitPrice
    {
        return $this->settingUnitPrice;
    }

    public function setSettingUnitPrice(?SettingUnitPrice $settingUnitPrice): static
    {
        $this->settingUnitPrice = $settingUnitPrice;

        return $this;
    }
}
