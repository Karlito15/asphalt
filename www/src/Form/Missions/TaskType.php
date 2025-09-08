<?php

namespace App\Form\Missions;

use App\Entity\MissionTask;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                'label'    => 'form.mission.task.value',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => MissionTask::class,
            'translation_domain' => 'forms',
        ]);
    }
}
