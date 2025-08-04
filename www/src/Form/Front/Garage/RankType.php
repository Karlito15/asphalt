<?php

namespace App\Form\Front\Garage;

use App\Able\Form\FormAble;
use App\Entity\GarageRank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RankType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('star0', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 7000,
                    'min'          => 0,
                ],
                'label'         => 'Start',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html'    => false,
                'required'      => false,
            ])
            ->add('star1', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 7000,
                    'min'          => 0,
                ],
                'label'         => $this->star(),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html'    => true,
                'required'      => false,
            ])
            ->add('star2', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 7000,
                    'min'          => 0,
                ],
                'label'         => $this->star(2),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html'    => true,
                'required'      => false,
            ])
            ->add('star3', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 7000,
                    'min'          => 0,
                ],
                'label'         => $this->star(3),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html'    => true,
                'required'      => false,
            ])
            ->add('star4', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 7000,
                    'min'          => 0,
                ],
                'label'         => $this->star(4),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html'    => true,
                'required'      => false,
            ])
            ->add('star5', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 7000,
                    'min'          => 0,
                ],
                'label'         => $this->star(5),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html'    => true,
                'required'      => false,
            ])
            ->add('star6', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 7000,
                    'min'          => 0,
                ],
                'label'         => $this->star(6),
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'label_html'    => true,
                'required'      => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageRank::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
