<?php

namespace App\Twig\Components\Value;

use DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'ValueDate',
    template: '@App/components/value/Date.html.twig',
)]
final class ValueDate
{
    private DateTime $value;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('value')->setAllowedTypes('value', 'DateTime');

        return $resolver->resolve($data);
    }
}
