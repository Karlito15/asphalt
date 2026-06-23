<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\SettingBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SettingBrandRepository::class)]
#[ORM\Table(name: 'setting_brand')]
#[ORM\Index(name: 'setting_brand_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class SettingBrand
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Type(type: ['integer'])]
    #[Groups(['index'])]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Unique]
    #[Groups(['index', 'migration'])]
    protected string $name;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['index'])]
    protected int $carsNumber = 0;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable: false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    #[Assert\Unique]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    #[Groups(['index', 'migration'])]
    protected string $slug;

    #[ORM\OneToMany(targetEntity: GarageApp::class, mappedBy: 'settingBrand')]
    protected Collection $garage;

    public function __construct()
    {
        $this->garage = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $garage->setSettingBrand($this);
        }

        return $this;
    }

    public function removeGarage(GarageApp $garage): static
    {
        if ($this->garage->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getSettingBrand() === $this) {
                $garage->setSettingBrand(null);
            }
        }

        return $this;
    }
}
