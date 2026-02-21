<?php

declare(strict_types=1);

namespace App\Toolbox\Abstract;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class UpgradeAbstract
{
    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 13)]
    protected int $speed = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 13)]
    protected int $acceleration = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 13)]
    protected int $handling = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 13)]
    protected int $nitro = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 36)]
    protected int $common = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 16)]
    protected int $rare = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 13)]
    protected int $epic = 0;

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getAcceleration(): ?int
    {
        return $this->acceleration;
    }

    public function setAcceleration(int $acceleration): static
    {
        $this->acceleration = $acceleration;

        return $this;
    }

    public function getHandling(): ?int
    {
        return $this->handling;
    }

    public function setHandling(int $handling): static
    {
        $this->handling = $handling;

        return $this;
    }

    public function getNitro(): ?int
    {
        return $this->nitro;
    }

    public function setNitro(int $nitro): static
    {
        $this->nitro = $nitro;

        return $this;
    }

    public function getCommon(): ?int
    {
        return $this->common;
    }

    public function setCommon(int $common): static
    {
        $this->common = $common;

        return $this;
    }

    public function getRare(): ?int
    {
        return $this->rare;
    }

    public function setRare(int $rare): static
    {
        $this->rare = $rare;

        return $this;
    }

    public function getEpic(): ?int
    {
        return $this->epic;
    }

    public function setEpic(int $epic): static
    {
        $this->epic = $epic;

        return $this;
    }
}
