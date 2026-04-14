<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\RaceTrackRepository;
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

#[ORM\Entity(repositoryClass: RaceTrackRepository::class)]
#[ORM\Table(name: 'race_track')]
#[ORM\Index(name: 'race_track_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['nameEnglish'])]
class RaceTrack
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
    protected string $nameEnglish;

    #[ORM\Column(type: Types::STRING, length: 64, unique:false, nullable:true)]
    #[Assert\Length(max: 64)]
    #[Assert\Type(type: ['null', 'string'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected ?string $nameFrench = null;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 3, max: 64)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['nameEnglish'], separator: '-')]
    protected string $slug;

    #[ORM\ManyToOne(targetEntity: RaceRegion::class, cascade: ['persist'], inversedBy: 'track')]
    #[Assert\Type(RaceRegion::class)]
    #[Groups(['index'])]
    protected ?RaceRegion $region = null;

    #[ORM\OneToMany(targetEntity: RaceApp::class, mappedBy: 'track', orphanRemoval: true)]
    protected Collection $race;

    public function __construct()
    {
        $this->race = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getNameEnglish();
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
     * @return Collection<int, RaceApp>
     */
    public function getRace(): Collection
    {
        return $this->race;
    }

    public function addRace(RaceApp $race): static
    {
        if (!$this->race->contains($race)) {
            $this->race->add($race);
            $race->setTrack($this);
        }

        return $this;
    }

    public function removeRace(RaceApp $race): static
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
