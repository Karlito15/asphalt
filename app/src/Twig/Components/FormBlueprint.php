<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'FormBlueprint',
    template: '@App/themes/lte/components/form/blueprint.html.twig',
)]
final class FormBlueprint
{
    public int|string $target = 0;

    public int|string $value = 0;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Autorise extras HTML
            ->setIgnoreUndefined(false)

            ### Required
            ->setRequired(['target', 'value'])

            ### Default
            ->setDefault('form', null)

            ### Types Allowed
            ->setAllowedTypes('target', ['int', 'string'])
            ->setAllowedTypes('value', ['int', 'string'])

            ### Allowed Values
        ;

        return $resolver->resolve($data);
    }

    /**
     * @return int
     */
    public function getTarget(): int
    {
        if ($this->target === 'Key') {
            return 1;
        }

        return (int) $this->target;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        if ($this->value === 'Key') {
            return 1;
        }

        return (int) $this->value;
    }

    /**
     * @return int
     */
    public function getRest(): int
    {
        return (int) ($this->getValue() - $this->getTarget());
    }
}
