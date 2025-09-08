<?php

namespace App\Form\Settings;

use App\Entity\SettingClass;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                ],
                'label'    => 'form.setting.class.label',
                'required' => true,
                'trim'     => true,
            ])
            ->add('value', TextType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                ],
                'label'    => 'form.setting.class.value',
                'required' => true,
                'trim'     => true,
            ])
            ->add('classOrder', NumberType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                ],
                'label'    => 'form.setting.class.classOrder',
                'required' => true,
                'trim'     => true,
            ])
            ->add('median', NumberType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                ],
                'label'    => 'form.setting.class.median',
                'required' => true,
                'trim'     => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => SettingClass::class,
            'translation_domain' => 'forms',
        ]);
    }
}
