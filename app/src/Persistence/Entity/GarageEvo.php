<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageEvoRepository;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageEvoRepository::class)]
#[ORM\Table(name: 'garage_evo')]
#[ORM\Index(name: 'garage_evo_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageEvo
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 24)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected int $number = 0;

    #[ORM\OneToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'evo')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }
}
