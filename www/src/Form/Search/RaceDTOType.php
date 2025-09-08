<?php

namespace App\Form\Search;

use App\Able\FormAble;
use App\DTO\SearchRaceDTO;
use App\Entity\RaceMode;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceDTOType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mode', EntityType::class, [
                'attr'        => [
                    'class' => 'form-control-lg',
                ],
                'class'       => RaceMode::class,
                'empty_data'  => null,
                'label'       => false,
                'placeholder' => 'Select a Mode',
                'required'    => false,
                'trim'        => false,
            ])
            ->add('season', EntityType::class, [
                'attr'        => [
                    'class' => 'form-control-lg',
                ],
                'class'         => RaceSeason::class,
                'label'         => false,
                'empty_data'  => null,
                'placeholder'   => 'Select a Season',
                'required'      => false,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('r')->addOrderBy('r.chapter', 'ASC')->addOrderBy('r.name', 'ASC');
                },
            ])
            ->add('time', EntityType::class, [
                'attr'        => [
                    'class' => 'form-control-lg',
                ],
                'class'       => RaceTime::class,
                'empty_data'  => null,
                'label'       => false,
                'placeholder' => 'Select a Time',
                'required'    => false,
            ])
            ->add('raceOrder', IntegerType::class, [
                'empty_data'  => null,
                'label'       => 'Race Order',
                'attr'        => [
                    'max' => 25,
                    'min' => 0,
                    'placeholder' => 'Race Order',
                    'step' => 1,
                ],
                'required'    => false,
                'trim'        => true,
            ])
            ->add('finished', CheckboxType::class, [
                'data'        => false,
                'empty_data'  => null,
                'label'       => 'Is Finish ?',
                'label_attr'  => [
                    'class' => 'checkbox'
                ],
                'required'    => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'allow_extra_fields' => false,
            'data_class'         => SearchRaceDTO::class,
            'method'             => 'GET',
            'translation_domain' => 'forms',
            // enable/disable CSRF protection for this form
            'csrf_protection'    => false,
        ]);
    }
}
