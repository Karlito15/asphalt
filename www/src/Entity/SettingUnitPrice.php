<?php

namespace App\Entity;

use App\Repository\SettingUnitPriceRepository;
use App\Service\Entities\SettingUnitPriceService;
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

#[ORM\Entity(repositoryClass: SettingUnitPriceRepository::class)]
#[ORM\Table(name: 'setting_unit_price')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'slug_idx', columns: ['slug'])]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['level01', 'level02', 'level03', 'level04', 'level05', 'level06', 'level07', 'level08', 'level09', 'level10', 'level11', 'level12', 'level13', 'common', 'rare', 'epic'])]
class SettingUnitPrice
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use SettingUnitPriceService;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    #[Groups(['index'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level01 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level02 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level03 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level04 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level05 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level06 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level07 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level08 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level09 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $level10 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private ?int $level11 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private ?int $level12 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private ?int $level13 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $common = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $rare = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private ?int $epic = null;

    #[ORM\Column(type: Types::STRING, length: 128, unique: true, nullable: false)]
    #[Assert\Length(min: 3, max: 128)]
    #[Gedmo\Versioned]
    private string $slug;

    #[ORM\OneToMany(targetEntity: AppGarage::class, mappedBy: 'settingUnitPrice')]
    protected Collection $garage;

    public function __construct()
    {
        $this->garage = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getSlug();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLevel01(): ?int
    {
        return $this->level01;
    }

    public function setLevel01(int $level01): static
    {
        $this->level01 = $level01;

        return $this;
    }

    public function getLevel02(): ?int
    {
        return $this->level02;
    }

    public function setLevel02(int $level02): static
    {
        $this->level02 = $level02;

        return $this;
    }

    public function getLevel03(): ?int
    {
        return $this->level03;
    }

    public function setLevel03(int $level03): static
    {
        $this->level03 = $level03;

        return $this;
    }

    public function getLevel04(): ?int
    {
        return $this->level04;
    }

    public function setLevel04(int $level04): static
    {
        $this->level04 = $level04;

        return $this;
    }

    public function getLevel05(): ?int
    {
        return $this->level05;
    }

    public function setLevel05(int $level05): static
    {
        $this->level05 = $level05;

        return $this;
    }

    public function getLevel06(): ?int
    {
        return $this->level06;
    }

    public function setLevel06(int $level06): static
    {
        $this->level06 = $level06;

        return $this;
    }

    public function getLevel07(): ?int
    {
        return $this->level07;
    }

    public function setLevel07(int $level07): static
    {
        $this->level07 = $level07;

        return $this;
    }

    public function getLevel08(): ?int
    {
        return $this->level08;
    }

    public function setLevel08(int $level08): static
    {
        $this->level08 = $level08;

        return $this;
    }

    public function getLevel09(): ?int
    {
        return $this->level09;
    }

    public function setLevel09(int $level09): static
    {
        $this->level09 = $level09;

        return $this;
    }

    public function getLevel10(): ?int
    {
        return $this->level10;
    }

    public function setLevel10(int $level10): static
    {
        $this->level10 = $level10;

        return $this;
    }

    public function getLevel11(): ?int
    {
        return $this->level11;
    }

    public function setLevel11(?int $level11): static
    {
        $this->level11 = $level11;

        return $this;
    }

    public function getLevel12(): ?int
    {
        return $this->level12;
    }

    public function setLevel12(?int $level12): static
    {
        $this->level12 = $level12;

        return $this;
    }

    public function getLevel13(): ?int
    {
        return $this->level13;
    }

    public function setLevel13(?int $level13): static
    {
        $this->level13 = $level13;

        return $this;
    }

    public function getCommon(): ?int
    {
        return $this->common;
    }

    public function setCommon(int $common): static
    {
        $this->common = $common;

        return $this;
    }

    public function getRare(): ?int
    {
        return $this->rare;
    }

    public function setRare(int $rare): static
    {
        $this->rare = $rare;

        return $this;
    }

    public function getEpic(): ?int
    {
        return $this->epic;
    }

    public function setEpic(?int $epic): static
    {
        $this->epic = $epic;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return Collection<int, AppGarage>
     */
    public function getGarage(): Collection
    {
        return $this->garage;
    }

    public function addGarage(AppGarage $garage): static
    {
        if (!$this->garage->contains($garage)) {
            $this->garage->add($garage);
            $garage->setSettingUnitPrice($this);
        }

        return $this;
    }

    public function removeGarage(AppGarage $garage): static
    {
        if ($this->garage->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getSettingUnitPrice() === $this) {
                $garage->setSettingUnitPrice(null);
            }
        }

        return $this;
    }
}
