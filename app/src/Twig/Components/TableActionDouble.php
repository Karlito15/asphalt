<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'TableActionDouble',
    template: '@App/components/table/action-double.html.twig',
)]
final class TableActionDouble
{
//    /** @var int $id ID of Entity */
//    private int $id = 0;
//
//    /** @var null $slug Slug of Entity */
//    private null $slug = null;
//
//    /** @var string $link Link of Update */
//    private string $link = '';
//
//    #[PreMount]
//    public function preMount(array $data): array
//    {
//        $resolver = new OptionsResolver();
//        $resolver
//            ->setRequired('id')
//            ->setAllowedTypes('id', 'integer')
//        ;
//        $resolver
//            ->setRequired('link')
//            ->setAllowedTypes('link', 'string')
//        ;
//        $resolver
//            ->setIgnoreUndefined('slug')
//        ;
//
//        return $resolver->resolve($data);
//    }
}
