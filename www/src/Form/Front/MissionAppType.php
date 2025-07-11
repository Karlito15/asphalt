<?php

namespace App\Form;

use App\Entity\MissionApp;
use App\Entity\MissionTask;
use App\Entity\MissionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionAppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('week')
            ->add('region')
            ->add('track')
            ->add('class')
            ->add('brand')
            ->add('description')
            ->add('success')
            ->add('target')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('task', EntityType::class, [
                'class' => MissionTask::class,
                'choice_label' => 'id',
            ])
            ->add('type', EntityType::class, [
                'class' => MissionType::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MissionApp::class,
        ]);
    }
}
