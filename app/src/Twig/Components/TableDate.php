<?php

declare(strict_types=1);

namespace App\Twig\Components;

use DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'TableDate',
    template: '@App/themes/lte/components/table/date.html.twig',
)]
final class TableDate
{
    /** @var DateTime|null $value Date of Action */
    private DateTime|null $value = null;

    /**
     * @param array $data
     * @return array
     */
    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
             ### Required
            ->setRequired('value')

            ### Default

            ### Types Allowed
            ->setAllowedTypes('value', ['DateTime', 'null'])
        ;

        return $resolver->resolve($data) + $data;
    }
}
