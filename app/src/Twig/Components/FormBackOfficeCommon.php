<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'FormBackOfficeCommon',
    template: 'form-back-office-common.html.twig',
)]
final class FormBackOfficeCommon
{
    /** @var mixed|null */
    private mixed $form = null;

    /** @var array */
    private array $link;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['form', 'link'])
            ->setAllowedTypes('link', 'array')
        ;

        return $resolver->resolve($data);
    }
}
