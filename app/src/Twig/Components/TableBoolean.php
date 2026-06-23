<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'TableBoolean',
    template: '@App/themes/lte/components/table/boolean.html.twig',
)]
final class TableBoolean
{
    private bool $value = false;

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

            ### Default
            ->setDefault('value', false)

            ### Types Allowed
            ->setAllowedTypes('value', 'bool')
        ;

        return $resolver->resolve($data);
    }
}
