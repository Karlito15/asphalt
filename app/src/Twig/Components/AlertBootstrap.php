<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'AlertBootstrap',
    template: '@App/components/alert/bootstrap.html.twig',
)]
final class AlertBootstrap
{
    public string $type = '';

    public ?string $message = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);  // Autorise extras HTML

        // Required
        $resolver->setRequired('type');
        $resolver->setAllowedTypes('type', 'string');

        // Optionnel avec default
        $resolver->setDefault('message', '');
        $resolver->setAllowedTypes('message', ['string', 'null']);

        // Valeurs autorisées
        $resolver->setAllowedValues('type', ['info', 'success', 'warning', 'danger', 'primary', 'secondary']);

        // Ajoute une valeur par défaut si absente
        if (!isset($data['type'])) {
            $data['type'] = 'info';
        }

        // Normalise une valeur
        if (isset($data['type'])) {
            $types = ['info', 'success', 'warning', 'danger', 'primary', 'secondary'];
            $data['type'] = in_array($data['type'], $types, true)
                ? $data['type']
                : 'info';
        }

        return $data;
    }
}
