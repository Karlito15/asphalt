<?php

namespace App\Entity;

use App\Repository\MissionTaskRepository;
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

#[ORM\Entity(repositoryClass: MissionTaskRepository::class)]
#[ORM\Table(name: 'mission_task')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'slug_idx', columns: ['slug'])]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['value'])]
class MissionTask
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
    #[Gedmo\Versioned]
    private string $value;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable:false)]
    #[Gedmo\Slug(fields: ['value'], separator: '-')]
    #[Gedmo\Versioned]
    private string $slug;

    #[ORM\OneToMany(targetEntity: AppMission::class, mappedBy: 'task', orphanRemoval: true)]
    private Collection $mission;

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
     * @return Collection<int, AppMission>
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(AppMission $mission): static
    {
        if (!$this->mission->contains($mission)) {
            $this->mission->add($mission);
            $mission->setTask($this);
        }

        return $this;
    }

    public function removeMission(AppMission $mission): static
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getTask() === $this) {
                $mission->setTask(null);
            }
        }

        return $this;
    }
}
