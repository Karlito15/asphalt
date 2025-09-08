<?php

namespace App\Form\App\Garage;

use App\Entity\GarageBlueprint;
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
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control form-control-sm text-center',
                ],
                'label'      => '<i class="fa-solid fa-star text-warning"></i>',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star2', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control form-control-sm text-center',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => '<i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i>',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star3', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control form-control-sm text-center',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => '<i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i>',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star4', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control form-control-sm text-center',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => '<i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i>',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star5', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control form-control-sm text-center',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => '<i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i>',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star6', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control form-control-sm text-center',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => '<i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i>',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => GarageBlueprint::class,
            'translation_domain' => 'forms',
        ]);
    }
}
