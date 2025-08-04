<?php

namespace App\Twig\Components\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

/**
 * Twig Component for Font Office FormGarage
 */
#[AsTwigComponent(
    name: 'FormGarageUpgrade',
    template: '@App/components/form/GarageUpgrade.html.twig',
)]
final class GarageUpgrade
{
    /** @var mixed|null */
    private mixed $form = null;

    /** @var float|int */
    private float|int $value = 0;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['form', 'value'])
            ->setAllowedTypes('value', ['float', 'int'])
        ;

        return $resolver->resolve($data);
    }
}
