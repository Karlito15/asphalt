<?php

namespace App\Entity;

use App\Repository\GarageRankRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageRankRepository::class)]
#[ORM\Table(name: 'garage_rank')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'name_idx', columns: ['id'])]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
//#[UniqueEntity(fields: ['label', 'value'], ignoreNull: 'value')]
class GarageRank
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private int $star0 = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private int $star1 = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private int $star2 = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private int $star3 = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private int $star4 = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private int $star5 = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private int $star6 = 0;

    #[ORM\ManyToOne(targetEntity: AppGarage::class, cascade: ['persist', 'remove'], inversedBy: 'rank')]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    private AppGarage $garage;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function __toString() : string
    {
        return $this->getGarage();
    }

    public function getStar0(): ?int
    {
        return $this->star0;
    }

    public function setStar0(int $star0): static
    {
        $this->star0 = $star0;

        return $this;
    }

    public function getStar1(): ?int
    {
        return $this->star1;
    }

    public function setStar1(int $star1): static
    {
        $this->star1 = $star1;

        return $this;
    }

    public function getStar2(): ?int
    {
        return $this->star2;
    }

    public function setStar2(int $star2): static
    {
        $this->star2 = $star2;

        return $this;
    }

    public function getStar3(): ?int
    {
        return $this->star3;
    }

    public function setStar3(int $star3): static
    {
        $this->star3 = $star3;

        return $this;
    }

    public function getStar4(): ?int
    {
        return $this->star4;
    }

    public function setStar4(int $star4): static
    {
        $this->star4 = $star4;

        return $this;
    }

    public function getStar5(): ?int
    {
        return $this->star5;
    }

    public function setStar5(int $star5): static
    {
        $this->star5 = $star5;

        return $this;
    }

    public function getStar6(): ?int
    {
        return $this->star6;
    }

    public function setStar6(int $star6): static
    {
        $this->star6 = $star6;

        return $this;
    }

    public function getGarage(): ?AppGarage
    {
        return $this->garage;
    }

    public function setGarage(?AppGarage $garage): static
    {
        $this->garage = $garage;

        return $this;
    }
}
