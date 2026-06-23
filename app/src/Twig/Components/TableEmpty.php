<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'TableEmpty',
    template: '@App/themes/lte/components/table/empty.html.twig',
)]
final class TableEmpty
{
    /** @var int $value number of column */
    private int $value = 6;

    /**
     * @param array $data
     * @return array
     */
    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Required
            ->setRequired('value')

            ### Types Allowed
            ->setAllowedTypes('value', ['integer'])

            ->setIgnoreUndefined()
        ;

        return $resolver->resolve($data) + $data;
    }
}
