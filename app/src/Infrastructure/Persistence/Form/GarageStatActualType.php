<?php

namespace App\Infrastructure\Persistence\Form;

use App\Infrastructure\Persistence\Entity\GarageStatActual;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatActualType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageStatActual::class,
        ]);
    }
}
