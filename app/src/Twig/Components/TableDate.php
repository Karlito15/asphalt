<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'TableDate',
    template: '@App/components/table-date.html.twig',
)]
final class TableDate
{
    /** @var $entity */
    private $entity;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('entity')
        ;

        return $resolver->resolve($data);
    }
}
