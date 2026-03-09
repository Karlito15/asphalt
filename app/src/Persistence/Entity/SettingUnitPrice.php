<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\SettingUnitPriceRepository;
use App\Service\Abstract\UnitPriceAbstract;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SettingUnitPriceRepository::class)]
#[ORM\Table(name: 'setting_unit_price')]
#[ORM\Index(name: 'setting_unit_price_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: [
    'level01', 'level02', 'level03', 'level04', 'level05',
    'level06', 'level07', 'level08', 'level09', 'level10',
    'level11', 'level12', 'level13', 'common', 'rare', 'epic',
])]
class SettingUnitPrice extends UnitPriceAbstract
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity;

    #[ORM\Column(type: Types::STRING, length: 128, unique: true, nullable: false)]
    #[Assert\Length(min: 3, max: 128)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration'])]
    protected string $slug;

    #[ORM\OneToMany(targetEntity: GarageApp::class, mappedBy: 'settingUnitPrice')]
    protected Collection $garage;

    public function __construct()
    {
        $this->garage = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getSlug();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function setSlug(): static
    {
        /** Total Value */
        $total  = (
            $this->getlevel01() + $this->getlevel02() + $this->getlevel03() + $this->getlevel04() +
            $this->getlevel05() + $this->getlevel06() + $this->getlevel07() + $this->getlevel08() +
            $this->getlevel09() + $this->getlevel10() + $this->getlevel11() + $this->getlevel12() +
            $this->getlevel13() + $this->getCommon() + $this->getRare() + $this->getEpic()
        );

        $string =
            str_pad((string) $total, 7, '0', STR_PAD_LEFT) . '|' .
            str_pad((string) $this->getlevel01(), 5, '0', STR_PAD_LEFT) . '-' .
            str_pad((string) $this->getlevel02(), 5, '0', STR_PAD_LEFT) . '-' .
            str_pad((string) $this->getlevel03(), 5, '0', STR_PAD_LEFT) . '-' .
            str_pad((string) $this->getcommon(), 5, '0', STR_PAD_LEFT) . '-' .
            str_pad((string) $this->getrare(), 6, '0', STR_PAD_LEFT) . '-' .
            str_pad((string) $this->getepic(), 6, '0', STR_PAD_LEFT)
        ;

        $this->slug = $string;

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
            $garage->setSettingUnitPrice($this);
        }

        return $this;
    }

    public function removeGarage(GarageApp $garage): static
    {
        if ($this->garage->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getSettingUnitPrice() === $this) {
                $garage->setSettingUnitPrice(null);
            }
        }

        return $this;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var SettingUnitPrice $object */
        $object = $args->getObject();
        if ($object instanceof self) {
            // Set Slug
            $object->setSlug();
        }
    }
}
