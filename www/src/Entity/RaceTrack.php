<?php

namespace App\Entity;

use App\Repository\RaceTrackRepository;
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

#[ORM\Entity(repositoryClass: RaceTrackRepository::class)]
#[ORM\Table(name: 'race_track')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'slug_idx', columns: ['slug'])]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['nameEnglish'])]
class RaceTrack
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
    #[ORM\Column(options: ['unsigned' => true])]
    #[Groups(['index'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private string $nameEnglish;

    #[ORM\Column(type: Types::STRING, length: 64, unique:false, nullable:true)]
    #[Assert\Length(max: 64)]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private ?string $nameFrench = null;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Gedmo\Slug(fields: ['nameEnglish'], separator: '-')]
    #[Gedmo\Versioned]
    private ?string $slug = null;

//    #[ORM\ManyToOne(fetch: 'EAGER')]
//    #[ORM\JoinColumn(name: "region_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[ORM\ManyToOne(targetEntity: RaceRegion::class, cascade: ['persist', 'remove'], inversedBy: 'track')]
    #[Assert\Type(RaceRegion::class)]
    private ?RaceRegion $region = null;

    #[ORM\OneToMany(targetEntity: AppRace::class, mappedBy: 'track', orphanRemoval: true)]
    private Collection $race;

    public function __construct()
    {
        $this->race = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getNameEnglish();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNameEnglish(): ?string
    {
        return $this->nameEnglish;
    }

    public function setNameEnglish(string $nameEnglish): static
    {
        $this->nameEnglish = $nameEnglish;

        return $this;
    }

    public function getNameFrench(): ?string
    {
        return $this->nameFrench;
    }

    public function setNameFrench(?string $nameFrench): static
    {
        $this->nameFrench = $nameFrench;

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

    public function getRegion(): ?RaceRegion
    {
        return $this->region;
    }

    public function setRegion(?RaceRegion $region): static
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, AppRace>
     */
    public function getRace(): Collection
    {
        return $this->race;
    }

    public function addRace(AppRace $race): static
    {
        if (!$this->race->contains($race)) {
            $this->race->add($race);
            $race->setTrack($this);
        }

        return $this;
    }

    public function removeRace(AppRace $race): static
    {
        if ($this->race->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getTrack() === $this) {
                $race->setTrack(null);
            }
        }

        return $this;
    }
}
