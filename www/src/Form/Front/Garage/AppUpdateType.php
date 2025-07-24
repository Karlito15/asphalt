<?php

namespace App\Form\Front\Garage;

use App\Able\Form\FormAble;
use App\Entity\GarageApp;
use App\Entity\SettingBlueprint;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Entity\SettingLevel;
use App\Entity\SettingTag;
use App\Entity\SettingUnitPrice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppUpdateType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Garage
            ->add('model', TextType::class, [
                'attr'          => [
                    'autocomplete'  => 'off',
                    'class'         => 'form-control',
                    'placeholder'   => 'form.model',
                ],
                'label'         => 'form.model',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'      => true,
                'trim'          => true,
            ])
            ->add('level', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'    => 'form.level',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required' => true,
            ])
            ->add('epic', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control',
                    'max'          => 16,
                    'min'          => 0,
                ],
                'label'    => 'form.epic',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required' => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'      => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control',
                    'min'          =>              0,
                ],
                'label'     => 'form.gameUpdate',
                'label_attr'    => [
                    'class' => 'm-0',
                ],
                'required'  => true,
                'trim'      => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => 'form-control',
                ],
                'choices'       => [
                    'form.3' => 3,
                    'form.4' => 4,
                    'form.5' => 5,
                    'form.6' => 6,
                ],
                'label'         => 'form.stars',
                'label_attr'    => [
                    'class' => 'm-0',
                ],
                'placeholder'   => 'form.stars',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('carOrder', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'p-2',
                    'max'          => 199,
                    'min'          => 0,
                ],
                'label' => 'form.carOrder',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required' => true,
            ])
            ->add('unlocked', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.unlocked',
                'required'   => false,
            ])
            ->add('gold', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.gold',
                'required'   => false,
            ])
            // Settings
            ->add('settingBlueprint', EntityType::class, [
                'attr'          => [
                    'class' => 'form-control form-select',
                ],
                'class'         => SettingBlueprint::class,
//                'choice_label' => 'id',
                'label'         => 'form.settingBlueprint',
                'label_attr'    => [
                    'class' => 'm-0',
                ],
                'placeholder'   => 'form.settingBlueprint',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingBrand', EntityType::class, [
                'attr'          => [
                    'class' => 'form-control form-select',
                ],
                'autocomplete'  => true,
                'choice_label'  => 'name',
                'class'         => SettingBrand::class,
//                'choice_label' => 'id',
                'label'         => 'form.settingBrand',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'placeholder'   => 'form.settingBrand',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingClass', EntityType::class, [
                'attr'          => [
                    'class' => 'form-control form-select',
                ],
                'choice_label'  => 'value',
                'class'         => SettingClass::class,
//                'choice_label' => 'id',
                'label'         => 'form.settingClass',
                'label_attr'    => [
                   'class' => 'm-0',
                ],
                'placeholder'   => 'form.settingClass',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingLevel', EntityType::class, [
                'attr' => [
                    'class' => 'form-control form-select',
                ],
                'class'       => SettingLevel::class,
//                'choice_label' => 'id',
                'label'       => 'form.settingLevel',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'placeholder' => 'form.settingLevel',
                'required'    => true,
                'trim'        => true,
            ])
            ->add('settingUnitPrice', EntityType::class, [
                'attr' => [
                    'class' => 'form-control form-select',
                ],
                'class'       => SettingUnitPrice::class,
//                'choice_label' => 'id',
                'label'       => 'form.settingUnitPrice',
                'label_attr'  => [
                    'class' => 'm-0',
                ],
                'placeholder' => 'form.settingUnitPrice',
                'required'    => true,
                'trim'        => true,
            ])
            // Collections
//            ->add('blueprint', CollectionType::class, [
//                'allow_add' => true,
//                'entry_type' => BlueprintType::class,
//            ])
//            ->add('rank', CollectionType::class, [
//                'allow_add' => true,
//                'entry_type' => RankType::class,
//            ])
//            ->add('statMax', CollectionType::class, [
//                'allow_add' => true,
//                'entry_type' => StatMaxType::class,
//            ])
//            ->add('statMin', CollectionType::class, [
//                'allow_add' => true,
//                'entry_type' => StatMinType::class,
//            ])
//            ->add('upgrade', CollectionType::class, [
//                'allow_add' => true,
//                'entry_type' => UpgradeType::class,
//            ])
//            ->add('settingTag', CollectionType::class, [
//                'allow_add' => true,
//                'entry_type' => SettingTag::class,
//            ])
            ->add('settingTag', EntityType::class, [
                'class'        => SettingTag::class,
                'choice_label' => 'id',
                'multiple'     => true,
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
}
