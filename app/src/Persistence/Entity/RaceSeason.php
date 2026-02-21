<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\RaceSeasonRepository;
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
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaceSeasonRepository::class)]
#[ORM\Table(name: 'race_season')]
#[ORM\Index(name: 'race_season_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['chapter', 'name'])]
#[UniqueEntity(fields: ['slug'])]
class RaceSeason
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity;

    #[ORM\Column(type: Types::SMALLINT, unique:false, nullable:false, options: ['default' => 1, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Range(min: 1, max: 6)]
    #[Assert\PositiveOrZero]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'race'])]
    protected int $chapter = 1;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'race'])]
    protected string $name;

    #[ORM\Column(type: Types::STRING, length: 128, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 128)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    #[Groups(['index'])]
    protected string $slug;

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

    public function setSlug(): static
    {
        $slugger = new AsciiSlugger();

        /** @var RaceSeason $this  */
        $this->slug = $this->getChapter() . '-' . $slugger->slug($this->getName())->lower();

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

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var RaceSeason $object */
        $object = $args->getObject();
        if ($object instanceof RaceSeason) {
            $object->setSlug();
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PreUpdate]
    public function preUpdate(LifecycleEventArgs $args): void
    {
        /* @var RaceSeason $object */
        $object = $args->getObject();
        if ($object instanceof RaceSeason) {
            // Set Slug
            $object->setSlug();
        }
    }
}
