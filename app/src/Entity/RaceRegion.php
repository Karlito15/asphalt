<?php

namespace App\Entity;

use App\Repository\RaceRegionRepository;
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
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['name'])]
class RaceRegion
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

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable:false)]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    #[Gedmo\Versioned]
    private string $slug;

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
