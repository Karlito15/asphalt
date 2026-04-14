<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Abstract\BlueprintAbstract;
use App\Domain\Repository\GarageBlueprintRepository;
use App\Domain\Service\Entity\{GarageEntity, IdEntity};
use DH\Auditor\Provider\Doctrine\Auditing\Attribute as Audit;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: GarageBlueprintRepository::class)]
#[ORM\Table(name: 'garage_blueprint')]
#[ORM\Index(name: 'garage_blueprint_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[Audit\Auditable]
class GarageBlueprint extends BlueprintAbstract
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, GarageEntity;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'blueprint', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;
}
