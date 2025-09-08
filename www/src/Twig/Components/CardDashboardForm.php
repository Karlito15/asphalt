<?php

namespace App\Twig\Components;

use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'CardDashboardForm',
    template: '@App/components/CardDashboardForm.html.twig',
)]
final class CardDashboardForm
{
    public FormView $form;

	public int $tabindex = 1;

	public int $maxValue = 99;

	public string $color = 'primary';

	public string $title = 'Card Name';

	public ?string $icon = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('tabindex')->setAllowedTypes('tabindex', 'integer');
        $resolver->setRequired('maxValue')->setAllowedTypes('maxValue', 'integer');
        $resolver->setRequired('color')->setAllowedTypes('color', 'string');
        $resolver->setRequired('title')->setAllowedTypes('title', 'string');
        $resolver->setRequired('icon')->setAllowedTypes('icon', ['string', 'null']);
        $resolver->setIgnoreUndefined('form');

        return $resolver->resolve($data);
    }
}
