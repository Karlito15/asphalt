<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'ListClass',
    template: '@App/components/ListClass.html.twig'
)]
final class ListClass
{
    public string $link = 'javascript:void(0);';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('link')->setAllowedTypes('link', 'string');

        return $resolver->resolve($data);
    }
}
