<?php

namespace App\Twig\Components\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'FormDelete',
    template: '@App/components/Form/Delete.html.twig',
)]
final class Delete
{
    /** @var int|null */
    private int|null $id = null;

    /** @var string */
    private string $link = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['id', 'link'])
            ->setAllowedTypes('id', ['int', 'null'])
            ->setAllowedTypes('link', 'string')
        ;

        return $resolver->resolve($data);
    }
}
