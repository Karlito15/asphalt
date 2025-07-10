<?php

namespace App\Twig\Components\Table;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'TableNoRecords',
    template: '@App/components/table/NoRecords.html.twig',
)]
final class NoRecords
{
    /** @var int number of column */
    private int $value = 6;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('value')->setAllowedTypes('value', 'integer');

        return $resolver->resolve($data);
    }
}
