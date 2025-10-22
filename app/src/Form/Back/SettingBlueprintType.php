<?php

declare(strict_types=1);

namespace App\Form\Back;

use App\Entity\SettingBlueprint;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingBlueprintType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('star1', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'max' => 3,
                ],
                'label' => 'form.star1',
                'required' => true,
                'trim' => true,
            ])
            ->add('star2', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'max' => 99,
                    'min' => 0,
                ],
                'label' => 'form.star2',
                'required' => true,
                'trim' => true,
            ])
            ->add('star3', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'max' => 99,
                    'min' => 0,
                ],
                'label' => 'form.star3',
                'required' => true,
                'trim' => true,
            ])
            ->add('star4', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'max' => 99,
                    'min' => 0,
                ],
                'label' => 'form.star4',
                'required' => false,
                'trim' => true,
            ])
            ->add('star5', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'max' => 99,
                    'min' => 0,
                ],
                'label' => 'form.star5',
                'required' => false,
                'trim' => true,
            ])
            ->add('star6', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'max' => 99,
                    'min' => 0,
                ],
                'label' => 'form.star6',
                'required' => false,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingBlueprint::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
