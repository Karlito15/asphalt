<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\Domain\Entity\InventoryApp;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'FormDashboardMoney',
    template: '@App/themes/lte/components/form/dashboard-money.html.twig',
)]
final class FormDashboardMoney
{
    public int $maxValue;

    public string|null $title;

    public string|null $icon ;

    public InventoryApp $entity;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Required
            ->setRequired(['maxValue', 'entity'])

            ### Default
            ->setDefault('maxValue', 0)
            ->setDefault('title', null)
            ->setDefault('icon', null)

            ### Types Allowed
            ->setAllowedTypes('maxValue', 'int')
            ->setAllowedTypes('title', ['null', 'string'])
            ->setAllowedTypes('icon', ['null', 'string'])
        ;

        return $resolver->resolve($data);
    }

    public function getMaxValue(): int
    {
        return $this->maxValue;
    }

    public function getIcon(): string
    {
        ### default icon
        if (is_null($this->icon)) {
            return '<i class="fa-solid fa-diamond fa-2x"></i>';
        }

        return '<i class="fa-solid ' . $this->icon . ' fa-2x"></i>';
    }

    public function getTitle(): ?string
    {
        return $this->title;
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
}
