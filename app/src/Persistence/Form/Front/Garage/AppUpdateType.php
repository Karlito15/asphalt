<?php

declare(strict_types=1);

namespace App\Persistence\Form\Front\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Entity\SettingBrand;
use App\Persistence\Entity\SettingClass;
use App\Persistence\Entity\SettingLevel;
use App\Persistence\Entity\SettingUnitPrice;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppUpdateType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Garage
            ->add('model', TextType::class, [
                'attr'          => [
                    'autocomplete'  => 'off',
                    'class'         => self::attrClass(),
                    'placeholder'   => 'form.model',
                ],
                'label'         => 'form.model',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])
            ->add('level', IntegerType::class, [
                'attr'          => [
                    'autocomplete' => 'off',
                    'class'        => self::attrClass(),
                    'max'          => 13,
                    'min'          => 0,
                    'placeholder'  => 'form.level',
                ],
                'label'         => 'form.level',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])
            ->add('epic', IntegerType::class, [
                'attr'          => [
                    'autocomplete' => 'off',
                    'class'        => self::attrClass(),
                    'max'          => 16,
                    'min'          => 0,
                    'placeholder'  => 'form.epic',
                ],
                'label'         => 'form.epic',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])
            ->add('evo', IntegerType::class, [
                'attr'          => [
                    'autocomplete' => 'off',
                    'class'        => self::attrClass(),
                    'max'          => 24,
                    'min'          => 0,
                    'placeholder'  => 'form.evo',
                ],
                'label'         => 'form.evo',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'          => [
                    'autocomplete' => 'off',
                    'class'        => self::attrClass(),
                    'min'          => 0,
                    'placeholder'  => 'form.gameUpdate',
                ],
                'label'         => 'form.gameUpdate',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'choices'       => [
                    'form.3' => 3,
                    'form.4' => 4,
                    'form.5' => 5,
                    'form.6' => 6,
                ],
                'label'         => 'form.stars',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.stars',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('carOrder', IntegerType::class, [
                'attr'          => [
                    'autocomplete' => 'off',
                    'class'        => self::attrClass(),
                    'max'          => 99,
                    'min'          => 0,
                    'placeholder'  => 'form.carOrder',
                ],
                'label'         => 'form.carOrder',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])

            // Settings
            ->add('settingBlueprint', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingBlueprint::class,
                'label'         => 'form.settingBlueprint',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.settingBlueprint',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingBrand', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                // 'autocomplete'  => true,
                'choice_label'  => 'name',
                'class'         => SettingBrand::class,
                'label'         => 'form.settingBrand',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.settingBrand',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingClass', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'choice_label'  => 'value',
                'class'         => SettingClass::class,
                'label'         => 'form.settingClass',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.settingClass',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingLevel', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingLevel::class,
                'label'         => 'form.settingLevel',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.settingLevel',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingUnitPrice', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingUnitPrice::class,
                'label'         => 'form.settingUnitPrice',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.settingUnitPrice',
                'required'      => true,
                'trim'          => true,
            ])

            // OneToOne
            ->add('blueprint', GarageBlueprintType::class)
            ->add('gauntlet', GarageGauntletType::class)
            ->add('rank', GarageRankType::class)
            ->add('statActual', GarageStatActualType::class)
            ->add('statMax', GarageStatMaxType::class)
            ->add('statMin', GarageStatMinType::class)
            ->add('status', GarageStatusType::class)
            ->add('upgrade', GarageUpgradeType::class)

            /*
            // Tags
            ->add('settingTag', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingTag::class,
                'multiple'      => true,
                'expanded'      => true, // Checkbox
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageApp::class,
            'allow_extra_fields' => false, // true
            'translation_domain' => 'forms',
        ]);
    }
}
