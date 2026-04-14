<?php

declare(strict_types=1);

namespace App\Domain\Form\Front\Search;

use App\Application\DTO\Search\RaceDTO;
use App\Domain\Entity\RaceMode;
use App\Domain\Entity\RaceRegion;
use App\Domain\Entity\RaceSeason;
use App\Domain\Entity\RaceTime;
use App\Domain\Service\Type\DefaultType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceAppType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mode', EntityType::class, [
                'class'       => RaceMode::class,
                'empty_data'  => null,
                'label'       => false,
                'placeholder' => 'form.placeholder.mode',
                'required'    => false,
                'trim'        => true,
            ])
            ->add('region', EntityType::class, [
                'attr'          => [
                    'disabled' => true,
                    'readonly' => true,
                ],
                'class'         => RaceRegion::class,
                'label'         => false,
                'empty_data'    => null,
                'placeholder'   => 'form.placeholder.region',
                'required'      => false,
                'trim'          => true,
            ])
            ->add('season', EntityType::class, [
                'class'         => RaceSeason::class,
                'label'         => false,
                'empty_data'    => null,
                'placeholder'   => 'form.placeholder.season',
                'required'      => false,
                'trim'          => true,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('r')->addOrderBy('r.chapter', 'ASC')->addOrderBy('r.name', 'ASC');
                },
            ])
            ->add('time', EntityType::class, [
                'class'       => RaceTime::class,
                'empty_data'  => null,
                'label'       => false,
                'placeholder' => 'form.placeholder.time',
                'required'    => false,
                'trim'        => true,
            ])
            ->add('raceOrder', IntegerType::class, [
                'attr'        => [
                    'max' => 30,
                    'min' => 0,
                    'placeholder' => 'form.placeholder.order.race',
                    'step' => 1,
                ],
                'empty_data'  => null,
                'label'       => false,
                'required'    => false,
                'trim'        => true,
            ])
            ->add('finished', CheckboxType::class, [
                'data'        => false,
                'empty_data'  => null,
                'label'       => 'form.placeholder.is.finish',
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
            'allow_extra_fields' => false,
            'csrf_protection' => false,
            'data_class' => RaceDTO::class,
            'method' => 'GET',
            'translation_domain' => 'messages',
        ]);
    }
}
