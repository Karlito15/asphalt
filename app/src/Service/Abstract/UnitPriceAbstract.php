<?php

declare(strict_types=1);

namespace App\Service\Abstract;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class UnitPriceAbstract
{
    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level01 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level02 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level03 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 99999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level04 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level05 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level06 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level07 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level08 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level09 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $level10 = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected ?int $level11 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9999999)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected ?int $level12 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 9999999)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected ?int $level13 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $common = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected int $rare = 0;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999999)]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration', 'sheet'])]
    protected ?int $epic = null;

    public function getLevel01(): ?int
    {
        return $this->level01;
    }

    public function setLevel01(int $level01): static
    {
        $this->level01 = $level01;

        return $this;
    }

    public function getLevel02(): ?int
    {
        return $this->level02;
    }

    public function setLevel02(int $level02): static
    {
        $this->level02 = $level02;

        return $this;
    }

    public function getLevel03(): ?int
    {
        return $this->level03;
    }

    public function setLevel03(int $level03): static
    {
        $this->level03 = $level03;

        return $this;
    }

    public function getLevel04(): ?int
    {
        return $this->level04;
    }

    public function setLevel04(int $level04): static
    {
        $this->level04 = $level04;

        return $this;
    }

    public function getLevel05(): ?int
    {
        return $this->level05;
    }

    public function setLevel05(int $level05): static
    {
        $this->level05 = $level05;

        return $this;
    }

    public function getLevel06(): ?int
    {
        return $this->level06;
    }

    public function setLevel06(int $level06): static
    {
        $this->level06 = $level06;

        return $this;
    }

    public function getLevel07(): ?int
    {
        return $this->level07;
    }

    public function setLevel07(int $level07): static
    {
        $this->level07 = $level07;

        return $this;
    }

    public function getLevel08(): ?int
    {
        return $this->level08;
    }

    public function setLevel08(int $level08): static
    {
        $this->level08 = $level08;

        return $this;
    }

    public function getLevel09(): ?int
    {
        return $this->level09;
    }

    public function setLevel09(int $level09): static
    {
        $this->level09 = $level09;

        return $this;
    }

    public function getLevel10(): ?int
    {
        return $this->level10;
    }

    public function setLevel10(int $level10): static
    {
        $this->level10 = $level10;

        return $this;
    }

    public function getLevel11(): ?int
    {
        return $this->level11;
    }

    public function setLevel11(?int $level11): static
    {
        $this->level11 = $level11;

        return $this;
    }

    public function getLevel12(): ?int
    {
        return $this->level12;
    }

    public function setLevel12(?int $level12): static
    {
        $this->level12 = $level12;

        return $this;
    }

    public function getLevel13(): ?int
    {
        return $this->level13;
    }

    public function setLevel13(?int $level13): static
    {
        $this->level13 = $level13;

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

    public function setEpic(?int $epic): static
    {
        $this->epic = $epic;

        return $this;
    }
}
