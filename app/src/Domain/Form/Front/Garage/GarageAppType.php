<?php

namespace App\Domain\Form\Front\Garage;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\GarageBlueprint;
use App\Domain\Entity\GarageGauntlet;
use App\Domain\Entity\GarageRank;
use App\Domain\Entity\GarageStatActual;
use App\Domain\Entity\GarageStatMax;
use App\Domain\Entity\GarageStatMin;
use App\Domain\Entity\GarageStatus;
use App\Domain\Entity\GarageStatusControl;
use App\Domain\Entity\GarageUpgrade;
use App\Domain\Entity\SettingBlueprint;
use App\Domain\Entity\SettingBrand;
use App\Domain\Entity\SettingClass;
use App\Domain\Entity\SettingLevel;
use App\Domain\Entity\SettingUnitPrice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageAppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model')
            ->add('stars')
            ->add('gameUpdate')
            ->add('carOrder')
            ->add('statOrder')
            ->add('level')
            ->add('epic')
            ->add('evo')
            ->add('blueprint', EntityType::class, [
                'class' => GarageBlueprint::class,
                'choice_label' => 'id',
            ])
            ->add('gauntlet', EntityType::class, [
                'class' => GarageGauntlet::class,
                'choice_label' => 'id',
            ])
            ->add('rank', EntityType::class, [
                'class' => GarageRank::class,
                'choice_label' => 'id',
            ])
            ->add('statActual', EntityType::class, [
                'class' => GarageStatActual::class,
                'choice_label' => 'id',
            ])
            ->add('statMax', EntityType::class, [
                'class' => GarageStatMax::class,
                'choice_label' => 'id',
            ])
            ->add('statMin', EntityType::class, [
                'class' => GarageStatMin::class,
                'choice_label' => 'id',
            ])
            ->add('status', EntityType::class, [
                'class' => GarageStatus::class,
                'choice_label' => 'id',
            ])
            ->add('statusControl', EntityType::class, [
                'class' => GarageStatusControl::class,
                'choice_label' => 'id',
            ])
            ->add('upgrade', EntityType::class, [
                'class' => GarageUpgrade::class,
                'choice_label' => 'id',
            ])
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
