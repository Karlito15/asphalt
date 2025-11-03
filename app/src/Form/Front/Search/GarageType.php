<?php

declare(strict_types=1);

namespace App\Form\Front\Search;

use App\DTO\Search\GarageDTO;
use App\Entity\GarageApp;
use App\Entity\SettingBrand;
use App\Trait\Form\FormTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gameUpdate', EntityType::class, [
//                'attr'        => [
//                    'class' => 'form-control-lg',
//                ],
                'class'        => GarageApp::class,
                'choice_label' => 'gameUpdate',
                'empty_data'   => null,
                'label'        => false,
                'placeholder'  => 'form.placeholder.update',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('g')->groupBy('g.gameUpdate')->orderBy('g.gameUpdate', 'DESC');
                },
                'required'     => false,
                'trim'         => true,
            ])
            ->add('brand', EntityType::class, [
//                'attr'        => [
//                    'class' => 'form-control-lg',
//                ],
                'class'        => SettingBrand::class,
                'choice_label' => 'name',
                'empty_data'   => null,
                'label'        => false,
                'placeholder'  => 'form.placeholder.brand',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('b')->orderBy('b.name', 'ASC');
                },
                'required'     => false,
                'trim'         => false,
            ])
            ->add('classLetter', ChoiceType::class, [
//                'attr'        => [
//                    'class' => 'form-control-lg',
//                ],
                'choices'       => [
                    'Class S' => 'S',
                    'Class A' => 'A',
                    'Class B' => 'B',
                    'Class C' => 'C',
                    'Class D' => 'D',
                ],
                'empty_data'    => null,
                'label'         => false,
                'placeholder'   => 'form.placeholder.class',
                'required'      => false,
                'trim'          => true,
            ])
            ->add('unlocked', ChoiceType ::class, [
//                'attr'        => [
//                    'class' => 'form-control-lg',
//                ],
                'choices'       => [
                    'No' => false,
                    'Yes' => true,
                ],
                'empty_data'    => null,
                'label'         => false, //'form.placeholder.unlocked',
                'placeholder'   => 'form.placeholder.unlocked',
                'required'      => false,
                'trim'          => true,
            ])
            ->add('gold', ChoiceType ::class, [
//                'attr'        => [
//                    'class' => 'form-control-lg',
//                ],
                'choices'       => [
                    'No' => false,
                    'Yes' => true,
                ],
                'empty_data'    => null,
                'label'         => false, //'form.placeholder.gold',
                'placeholder'   => 'form.placeholder.gold',
                'required'      => false,
                'trim'          => true,
            ])
            ->add('order', ChoiceType ::class, [
                'attr'        => [
//                    'class' => 'form-control-lg',
                    'disabled' => 'on',
                ],
                'choices'       => [
                    'Class' => 'carOrder',
                    'Stat' => 'statOrder',
                ],
                'empty_data'    => null,
                'label'         => false, //'form.placeholder.order',
                'placeholder'   => 'form.placeholder.order',
                'required'      => false,
                'trim'          => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => false,
            'data_class' => GarageDTO::class,
            'method' => 'GET',
            'translation_domain' => 'forms',
            // enable/disable CSRF protection for this form
            'csrf_protection' => false,
        ]);
    }
}
