<?php

namespace App\Twig\Components;

use DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'ValueDate',
    template: '@App/components/value-date.html.twig',
)]
final class ValueDate
{
    /** @var DateTime|null $value Date of Action */
    private DateTime|null $value = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('value')
            ->setAllowedTypes('value', ['DateTime', 'null'])
        ;

        return $resolver->resolve($data);
    }
}
