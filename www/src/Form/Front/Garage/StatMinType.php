<?php

namespace App\Form\Front\Garage;

use App\Entity\GarageApp;
use App\Entity\SettingBlueprint;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Entity\SettingLevel;
use App\Entity\SettingTag;
use App\Entity\SettingUnitPrice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatMinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stars')
            ->add('gameUpdate')
            ->add('carOrder')
            ->add('statOrder')
            ->add('level')
            ->add('epic')
            ->add('model')
            ->add('unlocked')
            ->add('gold')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('settingBlueprint', EntityType::class, [
                'class' => SettingBlueprint::class,
                'choice_label' => 'id',
            ])
            ->add('settingBrand', EntityType::class, [
                'class' => SettingBrand::class,
                'choice_label' => 'id',
            ])
            ->add('settingClass', EntityType::class, [
                'class' => SettingClass::class,
                'choice_label' => 'id',
            ])
            ->add('settingLevel', EntityType::class, [
                'class' => SettingLevel::class,
                'choice_label' => 'id',
            ])
            ->add('settingTag', EntityType::class, [
                'class' => SettingTag::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('settingUnitPrice', EntityType::class, [
                'class' => SettingUnitPrice::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageApp::class,
        ]);
    }
}
