<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'FormGroup',
    template: '@App/themes/lte/components/form/group.html.twig',
)]
final class FormGroup
{
    public int $column = 6;

    public int $maxValue = 99;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Autorise extras HTML
            ->setIgnoreUndefined()

            ### Required
            ->setRequired(['column', 'maxValue'])

            ### Default
            ->setDefault('column', 6)

            ### Types Allowed
            ->setAllowedTypes('column', 'int')
            ->setAllowedTypes('maxValue', 'int')

            ### Allowed Values
        ;

        return $resolver->resolve($data);
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function getMaxValue(): int
    {
        return $this->maxValue;
    }
}
