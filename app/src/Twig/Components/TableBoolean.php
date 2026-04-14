<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'TableBoolean',
    template: '@App/components/table/boolean.html.twig',
)]
final class TableBoolean
{
    /** @var bool $value */
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
            ->setRequired('value')
            ->setAllowedTypes('value', 'bool')
        ;

        return $resolver->resolve($data);
    }
}
