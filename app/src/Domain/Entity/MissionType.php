<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\MissionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionTypeRepository::class)]
#[ORM\Table(name: 'mission_type')]
#[ORM\Index(name: 'mission_type_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class MissionType
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Type(type: ['integer'])]
    #[Groups(['index'])]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Groups(['index', 'migration'])]
    protected string $value;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable:false)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string')]
    #[Gedmo\Slug(fields: ['value'], separator: '-')]
    protected string $slug;

    #[ORM\OneToMany(targetEntity: MissionApp::class, mappedBy: 'type', orphanRemoval: true)]
    protected Collection $mission;

    public function __construct()
    {
        $this->mission = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

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
     * @return Collection<int, MissionApp>
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(MissionApp $mission): static
    {
        if (!$this->mission->contains($mission)) {
            $this->mission->add($mission);
            $mission->setType($this);
        }

        return $this;
    }

    public function removeMission(MissionApp $mission): static
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getType() === $this) {
                $mission->setType(null);
            }
        }

        return $this;
    }
}
