<?php

namespace App\Entity;

use App\Repository\SettingClassRepository;
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

#[ORM\Entity(repositoryClass: SettingClassRepository::class)]
#[ORM\Table(name: 'setting_class')]
#[ORM\Index(name: 'setting_class_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['label', 'value'])]
class SettingClass
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
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 8, nullable:false)]
    #[Assert\Length(min: 1, max: 8)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private string $label;

    #[ORM\Column(type: Types::STRING, length: 8, nullable: false)]
    #[Assert\Length(min: 1, max: 8)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private string $value;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 1, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 1, max: 5)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $classOrder = 1;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 1, max: 99)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $carsNumber = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 125, max: 159)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $median = 125;

    #[ORM\Column(type: Types::STRING, length: 32, unique: true, nullable: false)]
    #[Gedmo\Slug(fields: ['label', 'value'], separator: '-')]
    #[Gedmo\Versioned]
    private string $slug;

    #[ORM\OneToMany(targetEntity: GarageApp::class, mappedBy: 'settingClass')]
    protected Collection $garage;

    public function __construct()
    {
        $this->garage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getSlug();
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getClassOrder(): ?int
    {
        return $this->classOrder;
    }

    public function setClassOrder(int $classOrder): static
    {
        $this->classOrder = $classOrder;

        return $this;
    }

    public function getCarsNumber(): ?int
    {
        return $this->carsNumber;
    }

    public function setCarsNumber(int $carsNumber): static
    {
        $this->carsNumber = $carsNumber;

        return $this;
    }

    public function getMedian(): ?int
    {
        return $this->median;
    }

    public function setMedian(int $median): static
    {
        $this->median = $median;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, GarageApp>
     */
    public function getGarage(): Collection
    {
        return $this->garage;
    }

    public function addGarage(GarageApp $garage): static
    {
        if (!$this->garage->contains($garage)) {
            $this->garage->add($garage);
            $garage->setSettingClass($this);
        }

        return $this;
    }

    public function removeGarage(GarageApp $garage): static
    {
        if ($this->garage->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getSettingClass() === $this) {
                $garage->setSettingClass(null);
            }
        }

        return $this;
    }
}
