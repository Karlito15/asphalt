<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\GarageStatusRepository;
use App\Domain\Service\Entity\{GarageEntity, IdEntity};
use DH\Auditor\Provider\Doctrine\Auditing\Attribute as Audit;
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
#[Audit\Auditable]
class GarageStatus
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['index', 'sheet', 'filter'])]
    protected bool $unblock = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['index', 'sheet', 'filter'])]
    protected bool $gold = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet', 'filter'])]
    protected bool $toUpgrade = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet', 'filter'])]
    protected bool $evo = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['sheet', 'filter'])]
    protected bool $eventClass = false;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'status', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['filter'])]
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

    public function isToUpgrade(): ?bool
    {
        return $this->toUpgrade;
    }

    public function setToUpgrade(bool $toUpgrade): static
    {
        $this->toUpgrade = $toUpgrade;

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
}
