<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'CardGarageStat',
    template: '@App/components/CardGarageStat.html.twig'
)]
final class CardGarageStat
{
    public bool $form = true;

    public mixed $min;

    public mixed $max;

    public string $background = 'primary';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('background')->setAllowedTypes('background', 'string');
        $resolver->setRequired('form')->setAllowedTypes('form', 'boolean');
        $resolver->setRequired('max'); // ->setDefined(['max'])
        $resolver->setRequired('min'); // ->setDefined(['min'])

        return $resolver->resolve($data);
    }
}
