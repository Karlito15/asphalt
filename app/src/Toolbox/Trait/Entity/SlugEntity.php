<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Entity;

trait SlugEntity
{
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
