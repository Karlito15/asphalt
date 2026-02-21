<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\SettingBrandRepository;
use App\Toolbox\Trait\Entity\IdEntity;
use App\Toolbox\Trait\Entity\SlugEntity;
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

#[ORM\Entity(repositoryClass: SettingBrandRepository::class)]
#[ORM\Table(name: 'setting_brand')]
#[ORM\Index(name: 'setting_brand_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['name'])]
class SettingBrand
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, SlugEntity;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'garage'])]
    protected string $name;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected int $cars_number = 0;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable: false)]
    #[Assert\Length(min: 3, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    #[Groups(['index'])]
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
        return $this->cars_number;
    }

    public function setCarsNumber(int $cars_number): static
    {
        $this->cars_number = $cars_number;

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
