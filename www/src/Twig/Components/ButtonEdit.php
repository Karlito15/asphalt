<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
	name: 'ButtonEdit',
	template: '@App/components/ButtonEdit.html.twig'
)]
final class ButtonEdit
{
    private int|string $id = 1;

    private string $slug   = '';

    private string $path   = 'app.dashboard.index';

    private bool $target   = false;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('id')->setAllowedTypes('id', ['integer', 'string']);
        $resolver->setRequired('slug')->setAllowedTypes('slug', ['string', 'null']);
        $resolver->setRequired('path')->setAllowedTypes('path', 'string');
        $resolver->setRequired('target')->setAllowedTypes('target', 'boolean');

        return $resolver->resolve($data);
    }
}
