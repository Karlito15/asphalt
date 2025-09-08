<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'CardGarageRank',
    template: '@App/components/CardGarageRank.html.twig'
)]
final class CardGarageRank
{
    public mixed $form;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['form'])->setIgnoreUndefined();

        return $resolver->resolve($data);
    }
}
