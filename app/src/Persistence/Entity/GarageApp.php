<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageAppRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageAppRepository::class)]
#[ORM\Table(name: 'garage_app')]
#[ORM\Index(name: 'garage_app_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity('slug')]
class GarageApp
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'sheet'])]
    protected ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, length: 1, nullable: false, options: ['default' => 3, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Assert\Range(min: 3, max: 6)]
    #[Groups(['sheet'])]
    protected int $stars = 3;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Groups(['index', 'sheet'])]
    protected int $gameUpdate = 0;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 99, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Assert\Range(min: 1, max: 99)]
    #[Groups(['sheet'])]
    protected int $carOrder = 99;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 99, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Assert\Range(min: 1, max: 99)]
    #[Groups(['sheet'])]
    protected int $statOrder = 99;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 13)]
    #[Groups(['sheet'])]
    protected int $level = 0;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 16,)]
    #[Groups(['sheet'])]
    protected int $epic = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 24)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'sheet'])]
    protected int $evo = 0;

    #[ORM\Column(type: Types::STRING, length: 128, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 128)]
    #[Groups(['index', 'sheet'])]
    protected string $model;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'sheet'])]
    protected string $slug;

    #[ORM\OneToOne(targetEntity: GarageBlueprint::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['sheet'])]
    protected GarageBlueprint $blueprint;

    #[ORM\OneToOne(targetEntity: GarageGauntlet::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['index', 'sheet'])]
    protected GarageGauntlet $gauntlet;

    #[ORM\OneToOne(targetEntity: GarageRank::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['sheet'])]
    protected GarageRank $rank;

    #[ORM\OneToOne(targetEntity: GarageStatActual::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['sheet'])]
    protected GarageStatActual $statActual;

    #[ORM\OneToOne(targetEntity: GarageStatMax::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['sheet'])]
    protected GarageStatMax $statMax;

    #[ORM\OneToOne(targetEntity: GarageStatMin::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['sheet'])]
    protected GarageStatMin $statMin;

    #[ORM\OneToOne(targetEntity: GarageStatus::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['index', 'sheet'])]
    protected GarageStatus $status;

    #[ORM\OneToOne(targetEntity: GarageStatusControl::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['index', 'sheet'])]
    protected GarageStatusControl $statusControl;

    #[ORM\OneToOne(targetEntity: GarageUpgrade::class, mappedBy: 'garage', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['sheet'])]
    protected GarageUpgrade $upgrade;

    #[ORM\ManyToOne(targetEntity: SettingBlueprint::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingBlueprint::class)]
    #[Groups(['sheet'])]
    protected ?SettingBlueprint $settingBlueprint = null;

    #[ORM\ManyToOne(targetEntity: SettingBrand::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingBrand::class)]
    #[Groups(['index', 'sheet'])]
    protected ?SettingBrand $settingBrand = null;

    #[ORM\ManyToOne(targetEntity: SettingClass::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingClass::class)]
    #[Groups(['index', 'sheet'])]
    protected ?SettingClass $settingClass = null;

    #[ORM\ManyToOne(targetEntity: SettingLevel::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingLevel::class)]
    #[Groups(['sheet'])]
    protected ?SettingLevel $settingLevel = null;

    #[ORM\ManyToOne(targetEntity: SettingUnitPrice::class, cascade: ['persist'], inversedBy: 'garage')]
    #[Assert\Type(SettingUnitPrice::class)]
    #[Groups(['sheet'])]
    protected ?SettingUnitPrice $settingUnitPrice = null;

    public function __toString(): string
    {
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

    public function getEvo(): int
    {
        return $this->evo;
    }

    public function setEvo(int $evo): static
    {
        $this->evo = $evo;

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
     * Set the slug for Garage
     *
     * @return $this
     */
    public function setSlug(): static
    {
        $slugger    = new AsciiSlugger();
        $this->slug = $slugger->slug($this->getSettingBrand()->getName())->lower() .
            '-' . $slugger->slug($this->getModel())->lower();

        return $this;
    }

    public function getBlueprint(): ?GarageBlueprint
    {
        return $this->blueprint;
    }

    public function setBlueprint(?GarageBlueprint $blueprint): static
    {
        // unset the owning side of the relation if necessary
        if ($blueprint === null && $this->blueprint !== null) {
            $this->blueprint->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($blueprint !== null && $blueprint->getGarage() !== $this) {
            $blueprint->setGarage($this);
        }

        $this->blueprint = $blueprint;

        return $this;
    }

    public function getGauntlet(): ?GarageGauntlet
    {
        return $this->gauntlet;
    }

    public function setGauntlet(?GarageGauntlet $gauntlet): static
    {
        // unset the owning side of the relation if necessary
        if ($gauntlet === null && $this->gauntlet !== null) {
            $this->gauntlet->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($gauntlet !== null && $gauntlet->getGarage() !== $this) {
            $gauntlet->setGarage($this);
        }

        $this->gauntlet = $gauntlet;

        return $this;
    }

    public function getRank(): ?GarageRank
    {
        return $this->rank;
    }

    public function setRank(?GarageRank $rank): static
    {
        // unset the owning side of the relation if necessary
        if ($rank === null && $this->rank !== null) {
            $this->rank->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($rank !== null && $rank->getGarage() !== $this) {
            $rank->setGarage($this);
        }

        $this->rank = $rank;

        return $this;
    }

    public function getStatActual(): ?GarageStatActual
    {
        return $this->statActual;
    }

    public function setStatActual(?GarageStatActual $statActual): static
    {
        // unset the owning side of the relation if necessary
        if ($statActual === null && $this->statActual !== null) {
            $this->statActual->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($statActual !== null && $statActual->getGarage() !== $this) {
            $statActual->setGarage($this);
        }

        $this->statActual = $statActual;

        return $this;
    }

    public function getStatMax(): ?GarageStatMax
    {
        return $this->statMax;
    }

    public function setStatMax(?GarageStatMax $statMax): static
    {
        // unset the owning side of the relation if necessary
        if ($statMax === null && $this->statMax !== null) {
            $this->statMax->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($statMax !== null && $statMax->getGarage() !== $this) {
            $statMax->setGarage($this);
        }

        $this->statMax = $statMax;

        return $this;
    }

    public function getStatMin(): ?GarageStatMin
    {
        return $this->statMin;
    }

    public function setStatMin(?GarageStatMin $statMin): static
    {
        // unset the owning side of the relation if necessary
        if ($statMin === null && $this->statMin !== null) {
            $this->statMin->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($statMin !== null && $statMin->getGarage() !== $this) {
            $statMin->setGarage($this);
        }

        $this->statMin = $statMin;

        return $this;
    }

    public function getStatus(): ?GarageStatus
    {
        return $this->status;
    }

    public function setStatus(?GarageStatus $status): static
    {
        // unset the owning side of the relation if necessary
        if ($status === null && $this->status !== null) {
            $this->status->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($status !== null && $status->getGarage() !== $this) {
            $status->setGarage($this);
        }

        $this->status = $status;

        return $this;
    }

    public function getStatusControl(): ?GarageStatusControl
    {
        return $this->statusControl;
    }

    public function setStatusControl(?GarageStatusControl $statusControl): static
    {
        // unset the owning side of the relation if necessary
        if ($statusControl === null && $this->statusControl !== null) {
            $this->statusControl->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($statusControl !== null && $statusControl->getGarage() !== $this) {
            $statusControl->setGarage($this);
        }

        $this->statusControl = $statusControl;

        return $this;
    }

    public function getUpgrade(): ?GarageUpgrade
    {
        return $this->upgrade;
    }

    public function setUpgrade(?GarageUpgrade $upgrade): static
    {
        // unset the owning side of the relation if necessary
        if ($upgrade === null && $this->upgrade !== null) {
            $this->upgrade->setGarage(null);
        }

        // set the owning side of the relation if necessary
        if ($upgrade !== null && $upgrade->getGarage() !== $this) {
            $upgrade->setGarage($this);
        }

        $this->upgrade = $upgrade;

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

    public function getSettingUnitPrice(): ?SettingUnitPrice
    {
        return $this->settingUnitPrice;
    }

    public function setSettingUnitPrice(?SettingUnitPrice $settingUnitPrice): static
    {
        $this->settingUnitPrice = $settingUnitPrice;

        return $this;
    }

    /**
     * Crée le slug lors de la création de l'entité
     *
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var GarageApp $object */
        $object = $args->getObject();
        if ($object instanceof GarageApp) {
            $object->setSlug();
        }
    }

    /**
     * Met à jour le slug si le model change
     *
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PreUpdate]
    public function preUpdate(LifecycleEventArgs $args): void
    {
        /* @var GarageApp $object */
        $object = $args->getObject();
        if ($object instanceof GarageApp) {
            $object->setSlug();
        }
    }
}
