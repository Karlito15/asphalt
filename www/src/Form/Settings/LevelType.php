<?php

namespace App\Form\Settings;

use App\Entity\SettingLevel;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LevelType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level', IntegerType::class, [
                 'attr'    => [
                    'autocomplete' => 'off',
                    'class'        => null,
                    'max'           => 13,
                    'min'           => 0,
                 ],
                'label'    => 'form.setting.level.level',
                'required' => true,
                'trim'     => true,
            ])
            ->add('common', IntegerType::class, [
                 'attr'    => [
                    'autocomplete'  => 'off',
                    'class'         => null,
                    'max'           => 36,
                    'min'           => 0,
                 ],
                'label'    => 'form.setting.level.common',
                'required' => true,
                'trim'     => true,
            ])
            ->add('rare', IntegerType::class, [
                 'attr'    => [
                    'autocomplete'  => 'off',
                    'class'         => null,
                    'max'           => 20,
                    'min'           => 0,
                 ],
                'label'    => 'form.setting.level.rare',
                'required' => true,
                'trim'     => true,
            ])
            ->add('epic', IntegerType::class, [
                 'attr'         => [
                    'autocomplete'  => 'off',
                    'class'         => null,
                    'max'           => 16,
                    'min'           => 0,
                 ],
                'label'    => 'form.setting.level.epic',
                'required' => true,
                'trim'     => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => SettingLevel::class,
            'translation_domain' => 'forms',
        ]);
    }
}
