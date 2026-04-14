<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Abstract\StatAbstract;
use App\Domain\Repository\GarageStatMaxRepository;
use App\Domain\Service\Entity\{GarageEntity, IdEntity};
use DH\Auditor\Provider\Doctrine\Auditing\Attribute as Audit;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: GarageStatMaxRepository::class)]
#[ORM\Table(name: 'garage_stat_max')]
#[ORM\Index(name: 'garage_stat_max_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[Audit\Auditable]
class GarageStatMax extends StatAbstract
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'statMax', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;
}
