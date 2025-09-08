<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'CardGarageBlueprint',
    template: '@App/components/CardGarageBlueprint.html.twig'
)]
final class CardGarageBlueprint
{
    public int $maxValue = 300;

    public int $total    = 300;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('maxValue')->setAllowedTypes('maxValue', 'integer');
        $resolver->setRequired('total')->setAllowedTypes('total', 'integer');

        return $resolver->resolve($data);
    }
}
