<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'FormBlueprintResume',
    template: '@App/components/form/blueprint-resume.html.twig',
)]
final class FormBlueprintResume
{
    /** @var int|string */
    public int|string $value;

    /** @return int|string */
    public function getValue(): int|string
    {
        return $this->value;
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('value')
            ->setAllowedTypes('value', ['integer', 'string'])
            ->setIgnoreUndefined()
        ;

        return $resolver->resolve($data) + $data;
    }
}
