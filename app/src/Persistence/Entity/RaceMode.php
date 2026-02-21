<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\RaceModeRepository;
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


#[ORM\Entity(repositoryClass: RaceModeRepository::class)]
#[ORM\Table(name: 'race_mode')]
#[ORM\Index(name: 'race_mode_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['name'])]
class RaceMode
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, SlugEntity;

    #[ORM\Column(type: Types::STRING, length: 32, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 32)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'race'])]
    protected string $name;

    #[ORM\Column(type: Types::STRING, length: 32, unique: true, nullable:false)]
    #[Assert\Length(min: 3, max: 32)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    #[Groups(['index'])]
    protected string $slug;

    #[ORM\OneToMany(targetEntity: RaceApp::class, mappedBy: 'mode', orphanRemoval: true)]
    protected Collection $race;

    public function __construct()
    {
        $this->race = new ArrayCollection();
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
            $race->setMode($this);
        }

        return $this;
    }

    public function removeRace(RaceApp $race): static
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
