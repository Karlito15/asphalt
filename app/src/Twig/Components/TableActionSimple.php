<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'TableActionSimple',
    template: '@App/components/table/action-simple.html.twig',
)]
final class TableActionSimple
{
    /** @var int $id ID of Entity */
    public int $id      = 0;

    /** @var string $link Link of Update */
    public string $link = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('id')
            ->setAllowedTypes('id', 'integer')
        ;
        $resolver
            ->setRequired('link')
            ->setAllowedTypes('link', 'string')
        ;

        return $resolver->resolve($data);
    }
}
