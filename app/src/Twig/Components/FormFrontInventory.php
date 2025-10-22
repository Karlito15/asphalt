<?php

namespace App\Twig\Components;

use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'FormFrontInventory',
    template: '@App/components/form-front-inventory.html.twig',
)]
final class FormFrontInventory
{
    /** @var int */
    public int $maxValue = 9;

    /** @var string */
    public string $color = 'primary';

    /** @var string|null */
    public string|null $icon = null;

    public FormView $form;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['maxValue', 'color', 'icon', 'form'])
            ->setAllowedTypes('maxValue', 'int')
            ->setAllowedTypes('color', 'string')
            ->setAllowedTypes('icon', ['null', 'string'])
            ->setAllowedTypes('form', FormView::class)
        ;

        return $resolver->resolve($data);
    }

    /** @return string */
    public function getColor(): string
    {
        return 'text-' . $this->color;
    }

    /** @return string */
    public function getIcon(): string
    {
        if (is_null($this->icon)) {
            return '<i class="fa-solid fa-diamond fa-2x '. $this->getColor() . '"></i>';
        }

        return '<i class="fa-solid ' . $this->icon . ' fa-3x ' . $this->getColor() . '"></i>';
    }
}
