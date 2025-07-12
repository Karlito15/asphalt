<?php

namespace App\Form\Front;

use App\Entity\RaceApp;
use App\Entity\RaceMode;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use App\Entity\RaceTrack;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceAppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raceOrder')
            ->add('finished')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('mode', EntityType::class, [
                'class' => RaceMode::class,
                'choice_label' => 'id',
            ])
            ->add('season', EntityType::class, [
                'class' => RaceSeason::class,
                'choice_label' => 'id',
            ])
            ->add('time', EntityType::class, [
                'class' => RaceTime::class,
                'choice_label' => 'id',
            ])
            ->add('track', EntityType::class, [
                'class' => RaceTrack::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RaceApp::class,
        ]);
    }
}
