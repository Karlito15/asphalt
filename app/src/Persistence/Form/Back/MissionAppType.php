<?php

declare(strict_types=1);

namespace App\Persistence\Form\Back;

use App\Persistence\Entity\MissionApp;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionAppType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                ],
                'label'    => 'text.value',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MissionApp::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }
}
