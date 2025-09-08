<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'CardGarageBlueprintForm',
    template: '@App/components/CardGarageBlueprintForm.html.twig'
)]
final class CardGarageBlueprintForm
{
    public mixed $maxValue = null;

    public mixed $form     = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('maxValue')->setAllowedTypes('maxValue', ['integer', 'string']);
        $resolver->setRequired('form');

        return $resolver->resolve($data);
    }
}
