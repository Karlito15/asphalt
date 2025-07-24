<?php

namespace App\Form\Front\Garage;

use App\Able\Form\FormAble;
use App\Entity\GarageApp;
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
                    'class'        => 'form-control-sm text-center fw-bolder text-success',
                ],
                'label'      => $this->star(),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star2', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control-sm text-center fw-bolder text-success',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => $this->star(2),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star3', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control-sm text-center fw-bolder text-success',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => $this->star(3),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star4', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control-sm text-center fw-bolder text-success',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => $this->star(4),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star5', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control-sm text-center fw-bolder text-success',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => $this->star(5),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star6', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'form-control-sm text-center fw-bolder text-success',
                    'max'          => 99,
                    'min'          => 0,
                ],
                'label'      => $this->star(6),
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
            'data_class' => GarageApp::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
