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
                    'placeholder'   => 'text.model',
                ],
                'label'         => 'text.model',
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
                    'placeholder'  => 'text.level',
                ],
                'label'         => 'text.level',
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
                    'placeholder'  => 'text.epic',
                ],
                'label'         => 'text.epic',
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
                    'placeholder'  => 'text.evo',
                ],
                'label'         => 'text.evo',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'          => [
                    'autocomplete' => 'off',
                    'class'        => self::attrClass(),
                    'min'          => 0,
                    'placeholder'  => 'text.game.update',
                ],
                'label'         => 'text.game.update',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'choices'       => [
                    'text.3' => 3,
                    'text.4' => 4,
                    'text.5' => 5,
                    'text.6' => 6,
                ],
                'label'         => 'text.stars',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'text.stars',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('carOrder', IntegerType::class, [
                'attr'          => [
                    'autocomplete' => 'off',
                    'class'        => self::attrClass(),
                    'max'          => 99,
                    'min'          => 0,
                    'placeholder'  => 'text.order.car',
                ],
                'label'         => 'text.order.car',
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
                'label'         => 'text.setting.blueprint',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'text.setting.blueprint',
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
                'label'         => 'text.setting.brand',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'text.setting.brand',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingClass', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'choice_label'  => 'value',
                'class'         => SettingClass::class,
                'label'         => 'text.setting.class',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'text.setting.class',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingLevel', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingLevel::class,
                'label'         => 'text.setting.level',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'text.setting.level',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingUnitPrice', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingUnitPrice::class,
                'label'         => 'text.setting.unit-price',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'text.setting.unit-price',
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
            'translation_domain' => 'messages',
        ]);
    }
}
