<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'FormFloating',
    template: '@App/themes/lte/components/form/floating.html.twig',
)]
final class FormFloating
{
    public int $column = 6;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Autorise extras HTML
            ->setIgnoreUndefined()

            ### Required
            ->setRequired([])//'column'

            ### Default
            ->setDefault('column', 6)

            ### Types Allowed
            ->setAllowedTypes('column', 'int')

            ### Allowed Values
            ->setAllowedValues('column', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])
        ;

        return $resolver->resolve($data);
    }

    public function getColumn(): int
    {
        return $this->column;
    }
}
