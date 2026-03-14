<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\SettingBlueprintRepository;
use App\Service\Abstract\BlueprintAbstract;
use App\Toolbox\Trait\Entity\IdEntity;
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

#[ORM\Entity(repositoryClass: SettingBlueprintRepository::class)]
#[ORM\Table(name: 'setting_blueprint')]
#[ORM\Index(name: 'setting_blueprint_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['star1', 'star2', 'star3', 'star4', 'star5', 'star6', 'total'])]
#[UniqueEntity(fields: ['slug'])]
class SettingBlueprint extends BlueprintAbstract
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable: false)]
    #[Assert\Length(min: 3, max: 64)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration'])]
    protected string $slug;

    #[ORM\OneToMany(targetEntity: GarageApp::class, mappedBy: 'settingBlueprint')]
    protected Collection $garage;

    public function __construct()
    {
        $this->garage = new ArrayCollection();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(): static
    {
        $this->slug =
            strtolower(str_pad($this->getStar1(), 3, '0', STR_PAD_LEFT)).'-'.
            str_pad((string) $this->getStar2(), 2, '0', STR_PAD_LEFT).'-'.
            str_pad((string) $this->getStar3(), 2, '0', STR_PAD_LEFT).'-'.
            str_pad((string) $this->getStar4(), 2, '0', STR_PAD_LEFT).'-'.
            str_pad((string) $this->getStar5(), 2, '0', STR_PAD_LEFT).'-'.
            str_pad((string) $this->getStar6(), 2, '0', STR_PAD_LEFT).'|'.
            strtolower(str_pad((string) $this->getTotal(), 3, '0', STR_PAD_LEFT))
        ;

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
            $garage->setSettingBlueprint($this);
        }

        return $this;
    }

    public function removeGarage(GarageApp $garage): static
    {
        if ($this->garage->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getSettingBlueprint() === $this) {
                $garage->setSettingBlueprint(null);
            }
        }

        return $this;
    }
}
