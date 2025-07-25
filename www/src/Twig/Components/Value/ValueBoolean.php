<?php

namespace App\Twig\Components\Value;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'ValueBoolean',
    template: '@App/components/value/Boolean.html.twig',
)]
final class ValueBoolean
{
    private bool $value = false;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('value')->setAllowedTypes('value', 'boolean');

        return $resolver->resolve($data);
    }
}
