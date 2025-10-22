<?php

declare(strict_types=1);

namespace App\Form\Back;

use App\Entity\MissionTask;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionTaskType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                ],
                'label'    => 'form.value',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MissionTask::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
