<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\MissionAppRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionAppRepository::class)]
#[ORM\Table(name: 'mission_app')]
#[ORM\Index(name: 'mission_app_idx', columns: ['id'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class MissionApp
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

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected int $week = 1;

    #[ORM\Column(type: Types::STRING, length: 64, nullable:true)]
    #[Groups(['index', 'migration'])]
    protected ?string $region = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable:true)]
    #[Groups(['index', 'migration'])]
    protected ?string $track = null;

    #[ORM\Column(type: Types::STRING, length: 16, nullable:true)]
    #[Groups(['index', 'migration'])]
    protected ?string $class = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable:true)]
    #[Groups(['index', 'migration'])]
    protected ?string $brand = null;

    #[ORM\Column(type: Types::STRING, length: 32, nullable:true)]
    #[Groups(['index', 'migration'])]
    protected ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected int $success = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected int $target = 1;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'mission')]
    #[ORM\JoinColumn(name: "task_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(MissionTask::class)]
    protected MissionTask $task;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'mission')]
    #[ORM\JoinColumn(name: "type_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(MissionType::class)]
    protected MissionType $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(int $week): static
    {
        $this->week = $week;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getTrack(): ?string
    {
        return $this->track;
    }

    public function setTrack(?string $track): static
    {
        $this->track = $track;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): static
    {
        $this->class = $class;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSuccess(): ?int
    {
        return $this->success;
    }

    public function setSuccess(int $success): static
    {
        $this->success = $success;

        return $this;
    }

    public function getTarget(): ?int
    {
        return $this->target;
    }

    public function setTarget(int $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function getTask(): ?MissionTask
    {
        return $this->task;
    }

    public function setTask(?MissionTask $task): static
    {
        $this->task = $task;

        return $this;
    }

    public function getType(): ?MissionType
    {
        return $this->type;
    }

    public function setType(?MissionType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
