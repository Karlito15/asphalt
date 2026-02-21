<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageUpgradeRepository;
use App\Toolbox\Abstract\UpgradeAbstract;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: GarageUpgradeRepository::class)]
#[ORM\Table(name: 'garage_upgrade')]
#[ORM\Index(name: 'garage_upgrade_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageUpgrade extends UpgradeAbstract
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\OneToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'upgrade', fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;
}
