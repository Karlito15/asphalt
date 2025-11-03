<?php

namespace App\Entity;

use App\Repository\GarageStatMinRepository;
use App\Trait\Entity\GarageStatTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: GarageStatMinRepository::class)]
#[ORM\Table(name: 'garage_stat_min')]
#[ORM\Index(name: 'garage_stat_min_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageStatMin
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use GarageStatTrait;

    #[ORM\ManyToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'statMin')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    private GarageApp $garage;
}
