<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\RaceRegionRepository;
use App\Domain\Service\Entity\{IdEntity, SlugEntity};
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

#[ORM\Entity(repositoryClass: RaceRegionRepository::class)]
#[ORM\Table(name: 'race_region')]
#[ORM\Index(name: 'race_region_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['name'])]
class RaceRegion
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, SlugEntity;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected string $name;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable:false)]
    #[Assert\Length(min: 3, max: 64)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    protected string $slug;

    #[ORM\OneToMany(targetEntity: RaceTrack::class, mappedBy: 'region')]
    protected Collection $track;

    public function __construct()
    {
        $this->track = new ArrayCollection();
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

    /**
     * @return Collection<int, RaceTrack>
     */
    public function getTrack(): Collection
    {
        return $this->track;
    }

    public function addTrack(RaceTrack $track): static
    {
        if (!$this->track->contains($track)) {
            $this->track->add($track);
            $track->setRegion($this);
        }

        return $this;
    }

    public function removeTrack(RaceTrack $track): static
    {
        if ($this->track->removeElement($track)) {
            // set the owning side to null (unless already changed)
            if ($track->getRegion() === $this) {
                $track->setRegion(null);
            }
        }

        return $this;
    }
}
