<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'ValueInteger',
    template: '@App/components/value-integer.html.twig',
)]
final class ValueInteger
{
    /** @var float|int|null $value */
    private float|int|null $value = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('value')
            ->setAllowedTypes('value', ['int', 'integer', 'null'])
        ;

        return $resolver->resolve($data);
    }
}
