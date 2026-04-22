<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'FormDashboardInventory',
    template: '@App/components/form/dashboard-inventory.html.twig',
)]
final class FormDashboardInventory
{
    /** @var int */
    public int $maxValue      = 999999999;

    /** @var string|null */
    public string|null $title = null;

    /** @var string|null */
    public string|null $theme = null;

    /** @var string|null */
    public string|null $icon  = null;

    /** @var bool */
    public bool $show         = false;

    public FormView $form;

    #[PreMount]
    public function preMount(array $data): array
    {
        ### Ajoute une valeur par défaut si absente
        if (!isset($data['theme'])) {
            $data['theme'] = 'secondary';
        }

        ### Normalise une valeur
        if (isset($data['theme'])) {
            $types = [
                'primary',
                'secondary',
                'dark',
                'white',
                'success',
                'info',
                'warning',
                'danger',
            ];
            $data['theme'] = in_array($data['theme'], $types, true) ? $data['theme'] : 'secondary';
        }

        if (is_string($data['maxValue'])) {
            $data['maxValue'] = (int) $data['maxValue'];
        }

        $resolver = new OptionsResolver();
        $resolver
            // Required
            ->setRequired(['maxValue', 'form'])

            // Optionnel avec default
            ->setDefault('maxValue', 0)
            ->setAllowedTypes('maxValue', 'int')
            ->setDefault('title', null)
            ->setAllowedTypes('title', ['null', 'string'])
            ->setDefault('theme', null)
            ->setAllowedTypes('theme', ['null', 'string'])
            ->setDefault('icon', null)
            ->setAllowedTypes('icon', ['null', 'string'])
            ->setDefault('show', false)
            ->setAllowedTypes('show', ['boolean'])
            ->setDefault('form', '')
            ->setAllowedTypes('form', FormView::class)
    ;

        return $resolver->resolve($data);
    }

    public function getMaxValue(): int
    {
        return $this->maxValue;
    }

    public function setMaxValue(int $maxValue): void
    {
        $this->maxValue = $maxValue;
    }

    public function getTheme(): string
    {
        ### default icon
        if (is_null($this->theme)) {
            return 'text-bg-primary';
        }

        return 'text-' . $this->theme;
    }

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }

    public function getIcon(): string
    {
        ### default icon
        if (is_null($this->icon)) {
            return '<i class="fa-solid fa-diamond fa-2x"></i>';
        }

        return '<i class="fa-solid ' . $this->icon . ' fa-2x"></i>';
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function isShow(): bool
    {
        return $this->show;
    }

    public function setShow(bool $show): void
    {
        $this->show = $show;
    }

    public function getForm(): FormView
    {
        return $this->form;
    }

    public function setForm(FormView $form): void
    {
        $this->form = $form;
    }
}
