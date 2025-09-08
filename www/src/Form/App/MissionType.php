<?php

namespace App\Form\App;

use App\Entity\AppMission;
use App\Entity\MissionTask as MissionTaskEntity;
use App\Entity\MissionType as MissionTypeEntity;
use App\Able\FormAble;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('week', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                ],
                'label'    => 'form.app.mission.week',
                'required' => true,
            ])
            ->add('region', TextType::class, [
                'label'    => 'form.app.mission.region',
                'required' => false,
                'trim'     => true,
            ])
            ->add('track', TextType::class, [
                'label'    => 'form.app.mission.track',
                'required' => false,
                'trim'     => true,
            ])
            ->add('class', TextType::class, [
                'label'    => 'form.app.mission.class',
                'required' => false,
                'trim'     => true,
            ])
            ->add('brand', TextType::class, [
                'label'    => 'form.app.mission.brand',
                'required' => false,
                'trim'     => true,
            ])
            ->add('description', TextType::class, [
                'label'    => 'form.app.mission.description',
                'required' => false,
                'trim'     => true,
            ])
            ->add('success', IntegerType::class, [
                'label'    => 'form.app.mission.success',
                'required' => true,
                'data'     => 0,
            ])
            ->add('target', IntegerType::class, [
                'label'    => 'form.app.mission.target',
                'required' => true,
                'data'     => 1,
            ])
            ->add('task', EntityType::class, [
                'class' => MissionTaskEntity::class,
                'choice_label' => 'id',
            ])
            ->add('type', EntityType::class, [
                'class' => MissionTypeEntity::class,
                'choice_label' => 'id',
            ])
//            ->add('task', EntityType::class, [
//                'autocomplete' => true,
//                'class'        => MissionTaskEntity::class,
//            ])
//            ->add('type', EntityType::class, [
//                'autocomplete' => true,
//                'class'        => MissionTypeEntity::class,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => AppMission::class,
            'translation_domain' => 'forms',
        ]);
    }
}
