<?php

namespace App\Form\App;

use App\Able\FormAble;
use App\Entity\AppGarage;
use App\Entity\SettingBlueprint;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Entity\SettingLevel;
use App\Entity\SettingUnitPrice;
use App\Form\App\Garage\BlueprintType;
use App\Form\App\Garage\BooleanType;
use App\Form\App\Garage\RankType;
use App\Form\App\Garage\StatMaxType;
use App\Form\App\Garage\StatMinType;
use App\Form\App\Garage\UpgradeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageUpdateType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /** Garage */
            ->add('model', TextType::class, [
                'attr'          => [
                    'autocomplete'  => 'off',
                    'class'         => 'form-control-lg',
                    'placeholder'   => 'form.app.garage.model',
                ],
                'label'         => 'form.app.garage.model',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'      => true,
                'trim'          => true,
            ])
            ->add('level', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control-lg text-center',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'    => 'form.app.garage.level',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required' => true,
            ])
            ->add('epic', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control-lg text-center',
                    'max'          => 16,
                    'min'          => 0,
                ],
                'label'    => 'form.app.garage.epic',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required' => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'      => [
                    'autocomplete' => 'off',
                    'class' => 'form-control-lg text-center',
                    'min' => 0,
                ],
                'label'     => 'form.app.garage.gameUpdate',
                'label_attr'    => [
                    'class' => 'm-0',
                ],
                'required'  => true,
                'trim'      => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => 'form-control-lg bg-primary',
                ],
                'choices'       => [
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ],
                'label'         => 'form.app.garage.stars',
                'label_attr'    => [
                    'class' => 'm-0',
                ],
                'placeholder'   => 'form.app.garage.stars',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('carOrder', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center p-2',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label' => 'form.app.garage.carOrder',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required' => true,
            ])
            /** Settings */
            ->add('settingBlueprint', EntityType::class, [
                'attr'          => [
                    'class' => 'form-control-lg bg-primary',
                ],
                'class'         => SettingBlueprint::class,
                'label'         => 'form.app.garage.settingBlueprint',
                'label_attr'    => [
                    'class' => 'm-0',
                ],
                'placeholder'   => 'form.app.garage.settingBlueprint',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingBrand', EntityType::class, [
                'attr'          => [
                    'class' => 'form-control',
                ],
                'autocomplete'  => true,
                'choice_label'  => 'name',
                'class'         => SettingBrand::class,
                'label'         => 'form.app.garage.settingBrand',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'placeholder'   => 'form.app.garage.settingBrand',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingClass', EntityType::class, [
                'attr'          => [
                    'class' => 'form-control form-select text-center',
                ],
                'choice_label'  => 'value',
                'class'         => SettingClass::class,
                'label'         => 'form.app.garage.settingClass',
                'label_attr'    => [
                   'class' => 'm-0',
                ],
                'placeholder'   => 'form.app.garage.settingClass',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingLevel', EntityType::class, [
                'attr' => [
                    'class' => 'form-control-lg bg-primary',
                ],
                'class'       => SettingLevel::class,
                'label'       => 'form.app.garage.settingLevel',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'placeholder' => 'form.app.garage.settingLevel',
                'required'    => true,
                'trim'        => true,
            ])
            ->add('settingUnitPrice', EntityType::class, [
                'attr' => [
                    'class' => 'form-control-lg bg-primary',
                ],
                'class'       => SettingUnitPrice::class,
                'label'       => 'form.app.garage.settingUnitPrice',
                'label_attr'  => [
                    'class' => 'm-0',
                ],
                'placeholder' => 'form.app.garage.settingUnitPrice',
                'required'    => true,
                'trim'        => true,
            ])
            /** Collections */
            ->add('blueprint', CollectionType::class, [
                'allow_add' => true,
                'entry_type' => BlueprintType::class,
            ])
            ->add('boolean', CollectionType::class, [
                'allow_add' => true,
                'entry_type' => BooleanType::class,
            ])
            ->add('rank', CollectionType::class, [
                'allow_add' => true,
                'entry_type' => RankType::class,
            ])
            ->add('statMax', CollectionType::class, [
                'allow_add' => true,
                'entry_type' => StatMaxType::class,
            ])
            ->add('statMin', CollectionType::class, [
                'allow_add' => true,
                'entry_type' => StatMinType::class,
            ])
            ->add('upgrade', CollectionType::class, [
                'allow_add' => true,
                'entry_type' => UpgradeType::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => AppGarage::class,
            'translation_domain' => 'forms',
        ]);
    }
}
