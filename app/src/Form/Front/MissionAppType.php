<?php

declare(strict_types=1);

namespace App\Form\Front;

use App\Entity\MissionApp;
use App\Entity\MissionTask;
use App\Entity\MissionType;
use App\Trait\Form\FormTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionAppType extends AbstractType
{
    use FormTrait;

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
                'class' => MissionTask::class,
                'choice_label' => 'id',
            ])
            ->add('type', EntityType::class, [
                'class' => MissionType::class,
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
            'data_class' => MissionApp::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
