<?php

namespace App\Entity;

use App\Repository\RaceSeasonRepository;
use App\Trait\Entity\RaceSeasonTrait;
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

#[ORM\Entity(repositoryClass: RaceSeasonRepository::class)]
#[ORM\Table(name: 'race_season')]
#[ORM\Index(name: 'race_season_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['chapter', 'name'])]
#[UniqueEntity(fields: ['slug'])]
class RaceSeason
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use RaceSeasonTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, unique:false, nullable:false, options: ['default' => 1, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Range(min: 1, max: 6)]
    #[Assert\PositiveOrZero]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private int $chapter = 1;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 128, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 128)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    #[Gedmo\Versioned]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: RaceApp::class, mappedBy: 'season', orphanRemoval: true)]
    protected Collection $race;

    public function __construct()
    {
        $this->race = new ArrayCollection();
    }

    public function __toString(): string
    {
        return '(Ch. ' . $this->getChapter() . ') - ' . $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChapter(): ?int
    {
        return $this->chapter;
    }

    public function setChapter(int $chapter): static
    {
        $this->chapter = $chapter;

        return $this;
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
            $race->setSeason($this);
        }

        return $this;
    }

    public function removeRace(RaceApp $race): static
    {
        if ($this->race->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getSeason() === $this) {
                $race->setSeason(null);
            }
        }

        return $this;
    }
}
