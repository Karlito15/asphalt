<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\GarageBlueprintStateRepository;
use App\Toolbox\Abstract\BlueprintAbstract;
use App\Toolbox\Trait\Entity\GarageEntity;
use App\Toolbox\Trait\Entity\IdEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageBlueprintStateRepository::class)]
#[ORM\Table(name: 'garage_blueprint_state')]
#[ORM\Index(name: 'garage_blueprint_state_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageBlueprintState extends BlueprintAbstract
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
    protected bool $fullBlueprintStar1 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullBlueprintStar2 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullBlueprintStar3 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullBlueprintStar4 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullBlueprintStar5 = false;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\NotNull]
    #[Assert\Type(type: ['boolean'])]
    protected bool $fullBlueprintStar6 = false;

    #[ORM\OneToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'blueprintState')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    protected GarageApp $garage;

    public function isFullBlueprintStar1(): ?bool
    {
        return $this->fullBlueprintStar1;
    }

    public function setFullBlueprintStar1(bool $fullBlueprintStar1): static
    {
        $this->fullBlueprintStar1 = $fullBlueprintStar1;

        return $this;
    }

    public function isFullBlueprintStar2(): ?bool
    {
        return $this->fullBlueprintStar2;
    }

    public function setFullBlueprintStar2(bool $fullBlueprintStar2): static
    {
        $this->fullBlueprintStar2 = $fullBlueprintStar2;

        return $this;
    }

    public function isFullBlueprintStar3(): ?bool
    {
        return $this->fullBlueprintStar3;
    }

    public function setFullBlueprintStar3(bool $fullBlueprintStar3): static
    {
        $this->fullBlueprintStar3 = $fullBlueprintStar3;

        return $this;
    }

    public function isFullBlueprintStar4(): ?bool
    {
        return $this->fullBlueprintStar4;
    }

    public function setFullBlueprintStar4(bool $fullBlueprintStar4): static
    {
        $this->fullBlueprintStar4 = $fullBlueprintStar4;

        return $this;
    }

    public function isFullBlueprintStar5(): ?bool
    {
        return $this->fullBlueprintStar5;
    }

    public function setFullBlueprintStar5(bool $fullBlueprintStar5): static
    {
        $this->fullBlueprintStar5 = $fullBlueprintStar5;

        return $this;
    }

    public function isFullBlueprintStar6(): ?bool
    {
        return $this->fullBlueprintStar6;
    }

    public function setFullBlueprintStar6(bool $fullBlueprintStar6): static
    {
        $this->fullBlueprintStar6 = $fullBlueprintStar6;

        return $this;
    }
}
