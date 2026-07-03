<?php

declare(strict_types=1);

namespace App\Twig\Components\Updater;

use App\Domain\Entity\InventoryApp;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'UpdaterMoney',
    template: '@App/themes/lte/components/updater/money.html.twig',
)]
final class Money
{
    public int $maxValue;

    public string|null $title;

    public string|null $icon;

    public string|null $background;

    public InventoryApp $entity;

    public function getMaxValue(): int
    {
        return $this->maxValue;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getIcon(): string
    {
        ### default icon
        if (is_null($this->icon)) {
            return '<i class="fa-solid fa-diamond fa-2x"></i>';
        }

        return '<i class="fa-solid ' . $this->icon . ' fa-2x"></i>';
    }

    public function getBackground(): ?string
    {
        ### default background
        if (is_null($this->background)) {
            return 'text-bg-secondary';
        }

        return 'text-bg-' . $this->background;
    }

    public function getId(): int
    {
        return $this->entity->getId();
    }

    public function getLabel(): string
    {
        return $this->entity->getLabel();
    }

    public function getValue(): int
    {
        return $this->entity->getValue();
    }

    public function getPosition(): int
    {
        return $this->entity->getPosition();
    }

    public function getSlug(): string
    {
        return $this->entity->getSlug();
    }

    public function getPercent(): float
    {
        return round(($this->getValue() / $this->getMaxValue()) * 100);
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Autorise extras HTML
            ->setIgnoreUndefined(false)

            ### Required
            ->setRequired(['maxValue', 'entity', 'title', 'icon', 'background'])

            ### Default
            ->setDefault('maxValue', 0)
            ->setDefault('title', null)
            ->setDefault('icon', null)
            ->setDefault('background', null)

            ### Types Allowed
            ->setAllowedTypes('maxValue', 'int')
            ->setAllowedTypes('title', ['null', 'string'])
            ->setAllowedTypes('icon', ['null', 'string'])
            ->setAllowedTypes('background', ['null', 'string'])
        ;

        return $resolver->resolve($data);
    }
}
