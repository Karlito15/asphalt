<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'FormBlueprintTotal',
    template: '@App/components/form/blueprint-total.html.twig',
)]
final class FormBlueprintTotal
{
    /** @var int|string */
    public int|string $total;

    /** @var int|string */
    public int|string $target;

    /** @return int|string */
    public function getTotal(): int|string
    {
        return $this->total;
    }

    /** @return int|string */
    public function getTarget(): int|string
    {
        return $this->target;
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('total')
            ->setAllowedTypes('total', ['integer', 'string'])
            ->setRequired('target')
            ->setAllowedTypes('target', ['integer', 'string'])
            ->setIgnoreUndefined()
        ;

        return $resolver->resolve($data) + $data;
    }
}
