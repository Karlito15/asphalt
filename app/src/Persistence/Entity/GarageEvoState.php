<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageEvoStateRepository;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageEvoStateRepository::class)]
#[ORM\Table(name: 'garage_evo_state')]
#[ORM\Index(name: 'garage_evo_state_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageEvoState
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    protected bool $all = false;

    #[ORM\OneToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'evoState')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;

    public function isAll(): ?bool
    {
        return $this->all;
    }

    public function setAll(bool $all): static
    {
        $this->all = $all;

        return $this;
    }
}
