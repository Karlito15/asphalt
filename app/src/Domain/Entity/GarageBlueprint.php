<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\GarageBlueprintRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarageBlueprintRepository::class)]
#[ORM\Table(name: 'garage_blueprint')]
#[ORM\Index(name: 'garage_blueprint_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class GarageBlueprint
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Type(type: ['integer'])]
    #[Groups(['index'])]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 3, nullable: false)]
    #[Assert\Length(min: 1, max: 3)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Groups(['index', 'migration'])]
    protected string $star1 = '0';

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['index', 'migration'])]
    protected int $star2 = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['index', 'migration'])]
    protected int $star3 = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'])]
    #[Groups(['index', 'migration'])]
    protected ?int $star4 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'])]
    #[Groups(['index', 'migration'])]
    protected ?int $star5 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'])]
    #[Groups(['index', 'migration'])]
    protected ?int $star6 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'])]
    #[Groups(['index', 'migration'])]
    protected ?int $total = null;

    #[ORM\OneToOne(targetEntity: GarageApp::class, inversedBy: 'blueprint', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'garage_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['filter'])]
    protected GarageApp $garage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStar1(): ?string
    {
        return $this->star1;
    }

    public function setStar1(string $star1): static
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

    public function getTotal(): ?int
    {
        return $this->total;
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

    public function setTotal(): static
    {
        $subtotal = $this->getStar2() + $this->getStar3() + $this->getStar4() + $this->getStar5() + $this->getStar6();

        if ($this->getStar1() === 'Key') {
            $this->total = $subtotal;
        } else {
            $this->total = (int) $this->getStar1() + $subtotal;
        }

        return $this;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $args->getObject()->setTotal();
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PostUpdate]
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $args->getObject()->setTotal();
        $args->getObjectManager()->getRepository(GarageBlueprint::class)->save($args->getObject(), true);
    }
}
