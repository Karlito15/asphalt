<?php

declare(strict_types=1);

namespace App\Persistence\Form\Back;

use App\Persistence\Entity\SettingClass;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingClassType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'text.label',
                'required' => true,
                'trim' => true,
            ])
            ->add('value', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'text.value',
                'required' => true,
                'trim' => true,
            ])
            ->add('classOrder', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'text.order.class',
                'required' => true,
                'trim' => true,
            ])
            ->add('median', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'text.median',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingClass::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }
}
