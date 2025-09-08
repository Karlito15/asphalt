<?php

namespace App\Entity;

use App\Repository\RaceModeRepository;
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

#[ORM\Entity(repositoryClass: RaceModeRepository::class)]
#[ORM\Table(name: 'race_mode')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'slug_idx', columns: ['slug'])]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['name'])]
class RaceMode
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

    #[ORM\Column(type: Types::STRING, length: 32, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 32)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 32, unique: true, nullable:false)]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    #[Gedmo\Versioned]
    private string $slug;

    #[ORM\OneToMany(targetEntity: AppRace::class, mappedBy: 'mode', orphanRemoval: true)]
    protected Collection $race;

    public function __construct()
    {
        $this->race = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?string
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
            $race->setMode($this);
        }

        return $this;
    }

    public function removeRace(AppRace $race): static
    {
        if ($this->race->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getMode() === $this) {
                $race->setMode(null);
            }
        }

        return $this;
    }
}
