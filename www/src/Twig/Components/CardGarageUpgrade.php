<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'CardGarageUpgrade',
    template: '@App/components/CardGarageUpgrade.html.twig'
)]
final class CardGarageUpgrade
{
    public mixed $form;

    public int $garage;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['form'])->setIgnoreUndefined();
        $resolver->setRequired('garage')->setAllowedTypes('garage', 'integer');

        return $resolver->resolve($data);
    }
}
