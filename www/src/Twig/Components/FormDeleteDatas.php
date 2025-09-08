<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'FormDeleteDatas',
    template: '@App/components/FormDeleteDatas.html.twig',
)]
final class FormDeleteDatas
{
    /**
     * @var int|string lien vers la page index
     */
    public int|string $link = 'javascript:void(0);';

    /**
     * @var int
     */
    public int $id = 0;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('link')->setAllowedTypes('link', 'string');
        $resolver->setRequired('id'); // ->setAllowedTypes('id', 'int')

        return $resolver->resolve($data);
    }
}
