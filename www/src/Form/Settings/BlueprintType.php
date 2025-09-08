<?php

namespace App\Form\Settings;

use App\Entity\SettingBlueprint;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlueprintType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('star1', TextType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                    'max'          => 3,
                ],
                'label'    => 'form.setting.blueprint.star1',
                'required' => true,
                'trim'     => true,
            ])
            ->add('star2', IntegerType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'    => 'form.setting.blueprint.star2',
                'required' => true,
                'trim'     => true,
            ])
            ->add('star3', IntegerType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'    => 'form.setting.blueprint.star3',
                'required' => true,
                'trim'     => true,
            ])
            ->add('star4', IntegerType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'    => 'form.setting.blueprint.star4',
                'required' => false,
                'trim'     => true,
            ])
            ->add('star5', IntegerType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'    => 'form.setting.blueprint.star5',
                'required' => false,
                'trim'     => true,
            ])
            ->add('star6', IntegerType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'    => 'form.setting.blueprint.star6',
                'required' => false,
                'trim'     => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => SettingBlueprint::class,
            'translation_domain' => 'forms',
        ]);
    }
}
