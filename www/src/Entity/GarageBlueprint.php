<?php

namespace App\Entity;

use App\Able\Entity\BlueprintAble;
use App\Repository\GarageBlueprintRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageBlueprintRepository::class)]
#[ORM\Table(name: 'garage_blueprint')]
#[ORM\Index(name: 'garage_blueprint_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageBlueprint
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use BlueprintAble;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 8, nullable: true)]
    #[Assert\Length(min: 1, max: 8)]
    private ?string $star1 = null;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    private ?int $star2 = null;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    private ?int $star3 = null;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    private ?int $star4 = null;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    private ?int $star5 = null;

    #[ORM\Column(type: Types::SMALLINT, length: 2, nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    private ?int $star6 = null;

    #[ORM\Column(type: Types::SMALLINT, length: 3, nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999)]
    private ?int $total = null;

    #[ORM\ManyToOne(targetEntity: GarageApp::class, cascade: ['persist'], inversedBy: 'blueprint')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    private GarageApp $garage;

    public function __toString() : string
    {
        return $this->getGarage();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStar1(): ?string
    {
        return $this->star1;
    }

    public function setStar1(?string $star1): static
    {
        $this->star1 = $star1;

        return $this;
    }

    public function getStar2(): ?int
    {
        return $this->star2;
    }

    public function setStar2(?int $star2): static
    {
        $this->star2 = $star2;

        return $this;
    }

    public function getStar3(): ?int
    {
        return $this->star3;
    }

    public function setStar3(?int $star3): static
    {
        $this->star3 = $star3;

        return $this;
    }

    public function getStar4(): ?int
    {
        return $this->star4;
    }

    public function setStar4(?int $star4): static
    {
        $this->star4 = $star4;

        return $this;
    }

    public function getStar5(): ?int
    {
        return $this->star5;
    }

    public function setStar5(?int $star5): static
    {
        $this->star5 = $star5;

        return $this;
    }

    public function getStar6(): ?int
    {
        return $this->star6;
    }

    public function setStar6(?int $star6): static
    {
        $this->star6 = $star6;

        return $this;
    }

    public function getGarage(): ?GarageApp
    {
        return $this->garage;
    }

    public function setGarage(?GarageApp $garage): static
    {
        $this->garage = $garage;

        return $this;
    }
}
