<?php

declare(strict_types=1);

namespace App\Toolbox\Abstract;

use App\Persistence\Entity\GarageBlueprint;
use App\Persistence\Entity\SettingBlueprint;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class BlueprintAbstract
{
    #[ORM\Column(type: Types::STRING, length: 3, nullable: true)]
    #[Assert\Length(min: 1, max: 3)]
    #[Assert\Type(type: ['null', 'string'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected ?string $star1 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected ?int $star2 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected ?int $star3 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected ?int $star4 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected ?int $star5 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected ?int $star6 = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    protected ?int $total = null;

    public function __toString(): string
    {
        return $this->getSlug();
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

    public function getTotal(): ?int
    {
        return $this->total;
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

    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageBlueprint) {
            $object->setTotal();
        }
        if ($object instanceof SettingBlueprint) {
            $object->setTotal()->setSlug();
        }
    }

    #[ORM\PostUpdate]
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof GarageBlueprint) {
            $object->setTotal();
            $args->getObjectManager()->getRepository(GarageBlueprint::class)->save($object, true);
        }
        if ($object instanceof SettingBlueprint) {
            $object->setTotal()->setSlug();
            $args->getObjectManager()->getRepository(SettingBlueprint::class)->save($object, true);
        }
    }
}
