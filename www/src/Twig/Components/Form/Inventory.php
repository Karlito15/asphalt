<?php

namespace App\Twig\Components\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

/**
 * Twig Component for Dashboard
 */
#[AsTwigComponent(
    name: 'FormInventory',
    template: '@App/components/form/Inventory.html.twig',
)]
final class Inventory
{
    /** @var int */
    public int $maxValue = 99;

    /** @var string */
    public string $color = 'primary';

    /** @var array */
    public array $datas  = [];

    /** @var string|null */
    public ?string $icon = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setIgnoreUndefined('icon')
            ->setRequired(['maxValue', 'color', 'datas', 'icon'])
            ->setAllowedTypes('maxValue', 'integer')
            ->setAllowedTypes('color', 'string')
            ->setAllowedTypes('datas', 'array')
            ->setAllowedTypes('icon', ['null', 'string'])
        ;

        return $resolver->resolve($data);
    }
}
