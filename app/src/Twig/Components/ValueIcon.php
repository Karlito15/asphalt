<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'ValueIcon',
    template: '@App/components/value-icon.html.twig',
)]
final class ValueIcon
{
    private int $repeat = 1;

    private string $icon = 'fa fa-house';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('repeat')
            ->setRequired('icon')
            ->setAllowedTypes('repeat', 'int')
            ->setAllowedTypes('icon', 'string')
        ;

        return $resolver->resolve($data);
    }
}
