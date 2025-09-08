<?php

namespace App\Form\Search;

use App\Able\FormAble;
use App\DTO\SearchGarageDTO;
use App\Entity\AppGarage;
use App\Entity\GarageBoolean;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageDTOType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('gameUpdate', EntityType::class, [
//                'class'        => AppGarage::class,
//                'choice_label' => 'gameUpdate',
//                'label'        => 'Select an Update',
//                'placeholder'  => 'Select an Update',
//                'query_builder' => function (EntityRepository $er): QueryBuilder {
//                    return $er->createQueryBuilder('g')->groupBy('g.gameUpdate')->orderBy('g.gameUpdate', 'DESC');
//                },
//                'required'     => false,
//                'trim'         => false,
//            ])
            ->add('classLetter', ChoiceType::class, [
                'choices'       => [
                    'Class S' => 'S',
                    'Class A' => 'A',
                    'Class B' => 'B',
                    'Class C' => 'C',
                    'Class D' => 'D',
                ],
                'empty_data'    => null,
                'label'         => 'Select a Class',
                'placeholder'   => 'Select a Class',
                'required'      => false,
                'trim'          => true,
            ])
            ->add('locked', CheckboxType ::class, [
                'data'          => false,
                'empty_data'    => null,
                'label'         => 'Is Locked ?',
                'label_attr'    => [
                    'class' => 'checkbox'
                ],
                'required'      => false,
            ])
//            ->add('gold', CheckboxType ::class, [
//                'data'          => false,
//                'empty_data'    => null,
//                'label'         => 'Is Gold ?',
//                'label_attr'    => [
//                    'class' => 'checkbox'
//                ],
//                'required'      => false,
//            ])
            ->add('gold', ChoiceType ::class, [
                'choices'       => [
                    'No' => false,
                    'Yes' => true,
                ],
                'empty_data'    => null,
                'expanded'      => true,
                'label'         => 'Is Gold ?',
                'label_attr'    => [
                    'class' => 'radio-inline'
                ],
                'multiple'      => false,
                'required'      => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'allow_extra_fields'    => false,
            'data_class'            => SearchGarageDTO::class,
            'extra_fields_message'  => true,
            'method'                => 'GET',
            'translation_domain'    => 'forms',
            // enable/disable CSRF protection for this form
            'csrf_protection'       => false,
        ]);
    }
}
