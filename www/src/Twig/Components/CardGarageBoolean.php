<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'CardGarageBoolean',
    template: '@App/components/CardGarageBoolean.html.twig'
)]
final class CardGarageBoolean
{
    public string $title = 'Title';

    public array $forms  = [];

    public array $values = [];

    public string $class = 'btn';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('title')->setAllowedTypes('title', 'string');
        $resolver->setRequired('class')->setAllowedTypes('class', 'string');
        $resolver->setRequired('forms')->setAllowedTypes('forms', 'array');
        $resolver->setRequired('values')->setAllowedTypes('values', 'array');

        return $resolver->resolve($data);
    }
}
