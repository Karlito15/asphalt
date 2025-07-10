<?php

namespace App\Form\Back;

use App\Entity\SettingUnitPrice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingUnitPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level01')
            ->add('level02')
            ->add('level03')
            ->add('level04')
            ->add('level05')
            ->add('level06')
            ->add('level07')
            ->add('level08')
            ->add('level09')
            ->add('level10')
            ->add('level11')
            ->add('level12')
            ->add('level13')
            ->add('common')
            ->add('rare')
            ->add('epic')
            ->add('slug')
            ->add('deletedAt')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingUnitPrice::class,
        ]);
    }
}
