<?php

namespace App\Persistence\Entity;

use App\Persistence\Repository\MissionTaskRepository;
use App\Persistence\Trait\Entity\MissionableEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionTaskRepository::class)]
#[ORM\Table(name: 'mission_task')]
#[ORM\Index(name: 'mission_task_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['value'])]
class MissionTask
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use MissionableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: MissionApp::class, mappedBy: 'task', orphanRemoval: true)]
    private Collection $mission;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addMission(MissionApp $mission): static
    {
        if (!$this->mission->contains($mission)) {
            $this->mission->add($mission);
            $mission->setTask($this);
        }

        return $this;
    }

    public function removeMission(MissionApp $mission): static
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
