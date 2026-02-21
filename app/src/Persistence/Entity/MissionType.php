<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\MissionTypeRepository;
use App\Toolbox\Abstract\MissionAbstract;
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

#[ORM\Entity(repositoryClass: MissionTypeRepository::class)]
#[ORM\Table(name: 'mission_type')]
#[ORM\Index(name: 'mission_type_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['value'])]
class MissionType extends MissionAbstract
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, SlugEntity;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable:false)]
    #[Assert\Length(min: 3, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['value'], separator: '-')]
    #[Groups(['index'])]
    protected string $slug;

    #[ORM\OneToMany(targetEntity: MissionApp::class, mappedBy: 'type', orphanRemoval: true)]
    protected Collection $mission;

    public function __construct()
    {
        $this->mission = new ArrayCollection();
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
