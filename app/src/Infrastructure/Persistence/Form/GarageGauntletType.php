<?php

namespace App\Infrastructure\Persistence\Form;

use App\Infrastructure\Persistence\Entity\GarageGauntlet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageGauntletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageGauntlet::class,
        ]);
    }
}
