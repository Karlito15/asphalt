<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'ButtonDelete',
    template: '@App/components/ButtonDelete.html.twig'
)]
final class ButtonDelete
{
    public int $id      = 1;

    public string $link = 'javascript:void(0);';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('id')->setAllowedTypes('id', 'integer');
        $resolver->setRequired('link')->setAllowedTypes('link', 'string');

        return $resolver->resolve($data);
    }
}
