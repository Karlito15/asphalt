<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'Boolean',
    template: '@App/components/Boolean.html.twig'
)]
final class Boolean
{
    public bool $value = false;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('value')->setAllowedTypes('value', 'boolean');

        return $resolver->resolve($data);
    }
}
