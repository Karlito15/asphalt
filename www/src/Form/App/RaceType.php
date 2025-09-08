<?php

namespace App\Form\App;

use App\Entity\AppRace;
use App\Entity\RaceMode;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use App\Entity\RaceTrack;
use App\Able\FormAble;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raceOrder', IntegerType::class, [
                'label'    => 'form.app.race.raceOrder',
                'required' => true,
                'trim'     => true,
            ])
            ->add('finished', ChoiceType::class, [
                'choices'  => [
                    'Finished' => true,
                    'None'     => false,
                ],
                'label'    => 'form.app.race.finished',
                'data'     => false,
                'required' => true,
                'trim'     => true,
            ])
            ->add('mode', EntityType::class, [
                'choice_label' => 'id',
                'class' => RaceMode::class,
                'label'       => 'form.app.race.mode',
                'placeholder' => 'Select a Mode',
                'required'    => true,
                'trim'        => true,
            ])
            ->add('season', EntityType::class, [
                'choice_label' => 'id',
                'class'        => RaceSeason::class,
                'label'        => 'form.app.race.season',
                'placeholder'  => 'Select a Season',
                'required'     => true,
                'trim'         => true,
            ])
            ->add('time', EntityType::class, [
                'choice_label' => 'id',
                'class'        => RaceTime::class,
                'label'        => 'form.app.race.time',
                'placeholder'  => 'Select a Time',
                'required'     => true,
                'trim'         => true,
            ])
            ->add('track', EntityType::class, [
                'choice_label' => 'id',
                'class'        => RaceTrack::class,
                'label'        => 'form.app.race.track',
                'placeholder'  => 'Select a Track',
                'required'     => true,
                'trim'         => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => AppRace::class,
            'translation_domain' => 'forms',

        ]);
    }
}
