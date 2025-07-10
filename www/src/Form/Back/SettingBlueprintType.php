<?php

namespace App\Form\Back;

use App\Entity\SettingBlueprint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingBlueprintType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('star1')
            ->add('star2')
            ->add('star3')
            ->add('star4')
            ->add('star5')
            ->add('star6')
            ->add('total')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingBlueprint::class,
        ]);
    }
}
