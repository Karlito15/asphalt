<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageStatusRepository;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageStatusRepository::class)]
#[ORM\Table(name: 'garage_status')]
#[ORM\Index(name: 'garage_status_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageStatus
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['index', 'sheet'])]
    protected bool $unblock = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['index', 'sheet'])]
    protected bool $gold = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $evo = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $eventClass = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet'])]
    protected bool $toUpgrade = false;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'status', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;

    public function isUnblock(): ?bool
    {
        return $this->unblock;
    }

    public function setUnblock(bool $unblock): static
    {
        $this->unblock = $unblock;

        return $this;
    }

    public function isGold(): ?bool
    {
        return $this->gold;
    }

    public function setGold(bool $gold): static
    {
        $this->gold = $gold;

        return $this;
    }

    public function isEvo(): ?bool
    {
        return $this->evo;
    }

    public function setEvo(bool $evo): static
    {
        $this->evo = $evo;

        return $this;
    }

    public function isEventClass(): ?bool
    {
        return $this->eventClass;
    }

    public function setEventClass(bool $eventClass): static
    {
        $this->eventClass = $eventClass;

        return $this;
    }

    public function isToUpgrade(): ?bool
    {
        return $this->toUpgrade;
    }

    public function setToUpgrade(bool $toUpgrade): static
    {
        $this->toUpgrade = $toUpgrade;

        return $this;
    }
}
