<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'TableEmpty',
    template: '@App/components/table/empty.html.twig',
)]
final class TableEmpty
{
    /** @var int $value number of column */
    private int $value = 6;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('value')
            ->setAllowedTypes('value', ['integer', 'string'])
            ->setIgnoreUndefined()
        ;

        return $resolver->resolve($data) + $data;
    }
}
