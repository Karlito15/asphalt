<?php

namespace App\Form\Back;

use App\Able\Form\FormAble;
use App\Entity\SettingClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingClassType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'form.label',
                'required' => true,
                'trim' => true,
            ])
            ->add('value', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'form.value',
                'required' => true,
                'trim' => true,
            ])
            ->add('classOrder', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'form.classOrder',
                'required' => true,
                'trim' => true,
            ])
//            ->add('cars_number', NumberType::class, [
//                'label' => 'form.cars_number',
//                'required' => false,
//                'trim' => true,
//            ])
            ->add('median', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'form.median',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingClass::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
