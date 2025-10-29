<?php

declare(strict_types=1);

namespace App\Form\Front;

use App\Entity\GarageApp;
use App\Entity\SettingBlueprint;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Entity\SettingLevel;
use App\Entity\SettingTag;
use App\Entity\SettingUnitPrice;
use App\Trait\Form\FormTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageAppUpdateType extends AbstractType
{
    use FormTrait;

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
                    'class'        => 'text-center fw-bolder form-control-sm form-control',
                    'max'          => 99,
                    'min'          => 0,
                    'placeholder'  => 'form.carOrder',
                ],
                'label'         => 'form.carOrder',
                'label_attr'    => self::labelClass(),
                'required'      => true,
                'trim'          => true,
            ])
            ->add('unlocked', CheckboxType::class, [
                'attr'          => [
                    'class' => 'btn-check'
                ],
                'label'         => 'form.unlocked',
                'required'      => false,
            ])
            ->add('gold', CheckboxType::class, [
                'attr'          => [
                    'class' => 'btn-check'
                ],
                'label'         => 'form.gold',
                'required'      => false,
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
//                    'class' => self::attrClass(),
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

            // Collections
            ->add('blueprint', CollectionType::class, [
                'allow_add'     => true,
                'entry_type'    => GarageBlueprintType::class,
            ])
            ->add('rank', CollectionType::class, [
                'allow_add'     => true,
                'entry_type'    => GarageRankType::class,
            ])
            ->add('statMax', CollectionType::class, [
                'allow_add'     => true,
                'entry_type'    => GarageStatMaxType::class,
            ])
            ->add('statMin', CollectionType::class, [
                'allow_add'     => true,
                'entry_type'    => GarageStatMinType::class,
            ])
            ->add('upgrade', CollectionType::class, [
                'allow_add'     => true,
                'entry_type'    => GarageUpgradeType::class,
            ])
            ->add('settingTag', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingTag::class,
                'multiple'      => true,
                'expanded'      => true, // Checkbox
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => GarageApp::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }

    /**
     * @return string
     */
    private static function attrClass(): string
    {
//        return 'text-start fw-bolder m-0 px-3 py-0 form-control-sm';
        return 'fw-bolder';
    }
}
