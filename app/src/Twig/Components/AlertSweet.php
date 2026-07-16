<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'AlertSweet',
    template: '@App/themes/lte/components/alert/sweet.html.twig',
)]
final class AlertSweet
{
    public string $type = 'success';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Autorise extras HTML
            ->setIgnoreUndefined(false)

            ### Required
            ->setRequired(['message'])

            ### Default
            ->setDefault('type', 'success')
            ->setDefault('message', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')

            ### Types Allowed
            ->setAllowedTypes('type', ['string'])
            ->setAllowedTypes('message', ['string'])

            ### Valeurs autorisées
            ->setAllowedValues('type', ['info', 'success', 'warning', 'error', 'question'])
        ;

        return $resolver->resolve($data);
    }
}
