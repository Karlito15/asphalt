<?php

namespace App\Twig\Components;

use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'CardInventory',
    template: '@App/components/card/inventory.html.twig',
)]
final class CardInventory
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
        ### Ajoute une valeur par défaut si absente
        if (!isset($data['color'])) {
            $data['color'] = 'info';
        }

        ### Normalise une valeur
        if (isset($data['color'])) {
            $types = [
                'info',
                'success',
                'warning',
                'danger',
                'primary',
                'secondary',
                'info-emphasis',
                'success-emphasis',
                'warning-emphasis',
                'danger-emphasis'
            ];
            $data['color'] = in_array($data['color'], $types, true)
                ? $data['color']
                : 'info'
            ;
        }

        if (is_string($data['maxValue'])) {
            $data['maxValue'] = (int) $data['maxValue'];
        }

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
        ### default icon
        if (is_null($this->icon)) {
            return '<i class="fa-solid fa-diamond fa-2x '. $this->getColor() . '"></i>';
        }

        return '<i class="fa-solid ' . $this->icon . ' fa-3x ' . $this->getColor() . '"></i>';
    }
}
