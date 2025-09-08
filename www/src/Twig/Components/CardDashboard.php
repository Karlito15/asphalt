<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'CardDashboard',
    template: '@App/components/CardDashboard.html.twig',
)]
final class CardDashboard
{
	public int $tabindex = 1;

	public int $maxValue = 99;

	public string $color = 'primary';

	public string $title = 'Card Name';

	public ?string $icon = null;

	public array $datas  = [];

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('tabindex')->setAllowedTypes('tabindex', 'integer');
        $resolver->setRequired('maxValue')->setAllowedTypes('maxValue', 'integer');
        $resolver->setRequired('color')->setAllowedTypes('color', 'string');
        $resolver->setRequired('title')->setAllowedTypes('title', 'string');
        $resolver->setRequired('icon')->setAllowedTypes('icon', ['string', 'null']);
        $resolver->setRequired('datas')->setAllowedTypes('datas', 'array');

        return $resolver->resolve($data);
    }
}
