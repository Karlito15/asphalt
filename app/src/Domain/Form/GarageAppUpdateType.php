<?php

declare(strict_types=1);

namespace App\Domain\Form;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBlueprint;
use App\Domain\Entity\SettingBrand;
use App\Domain\Entity\SettingClass;
use App\Domain\Entity\SettingLevel;
use App\Domain\Entity\SettingUnitPrice;
use App\Infrastructure\Abstract\Form\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageAppUpdateType extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ### Garage
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
                    'placeholder'  => 'form.game.update',
                ],
                'label'         => 'form.game.update',
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
                    'placeholder'  => 'form.order.class',
                ],
                'label'         => 'form.order.class',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])

            ### Settings
            ->add('settingBlueprint', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingBlueprint::class,
                'label'         => 'form.blueprint',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.blueprint',
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
                'label'         => 'form.brand',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.brand',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingClass', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'choice_label'  => 'value',
                'class'         => SettingClass::class,
                'label'         => 'form.class',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.class',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingLevel', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingLevel::class,
                'label'         => 'form.level',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.level',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingUnitPrice', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingUnitPrice::class,
                'label'         => 'form.unit-price',
                'label_attr'    => self::labelClass(),
                'placeholder'   => 'form.unit-price',
                'required'      => true,
                'trim'          => true,
            ])

            ### OneToOne
            ->add('blueprint', GarageBlueprintType::class)
            ->add('gauntlet', GarageGauntletType::class)
            ->add('rank', GarageRankType::class)
            ->add('statActual', GarageStatActualType::class)
            ->add('statMax', GarageStatMaxType::class)
            ->add('statMin', GarageStatMinType::class)
            ->add('status', GarageStatusType::class)
            ->add('statusControl', GarageStatusControlType::class)
            ->add('upgrade', GarageUpgradeType::class)

            /*
            ### Tags
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
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',//messages
        ]);
    }
}
