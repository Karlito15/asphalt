<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait IdEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
