<?php

declare(strict_types=1);

namespace App\Twig\Components\Reader;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'ReaderGroup',
    template: '@App/themes/lte/components/reader/group.html.twig',
)]
final class Group
{
    public null|string $label = null;

    public null|string $icon = null;

    public int $value = 0;

    public int $max = 0;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getIcon(): string
    {
        ### default icon
        if (is_null($this->icon)) {
            return '<i class="fa-solid fa-diamond fa-2x"></i>';
        }

        return '<i class="fa-solid ' . $this->icon . ' fa-2x"></i>';
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Required
            ->setRequired(['label', 'icon', 'value', 'max'])

            ### Default
            ->setDefault('label', null)
            ->setDefault('icon', null)
            ->setDefault('value', 0)
            ->setDefault('max', 0)

            ### Types Allowed
            ->setAllowedTypes('label', ['null', 'string'])
            ->setAllowedTypes('icon', ['null', 'string'])
            ->setAllowedTypes('value', 'int')
            ->setAllowedTypes('max', 'int')
        ;

        return $resolver->resolve($data);
    }
}
