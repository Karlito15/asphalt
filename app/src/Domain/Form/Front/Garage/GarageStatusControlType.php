<?php

namespace App\Domain\Form\Front\Garage;

use App\Domain\Entity\GarageStatusControl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatusControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('toInstallSpeed')
            ->add('fullSpeed')
            ->add('toInstallAcceleration')
            ->add('fullAcceleration')
            ->add('toInstallHandling')
            ->add('fullHandling')
            ->add('toInstallNitro')
            ->add('fullNitro')
            ->add('toInstallCommon')
            ->add('fullCommon')
            ->add('toInstallRare')
            ->add('fullRare')
            ->add('toInstallEpic')
            ->add('fullEpic')
            ->add('fullStar1')
            ->add('fullStar2')
            ->add('fullStar3')
            ->add('fullStar4')
            ->add('fullStar5')
            ->add('fullStar6')
            ->add('fullBlueprint')
            ->add('toInstallUpgrade')
            ->add('fullUpgrade')
            ->add('toInstallImport')
            ->add('fullImport')
            ->add('toGold')
            ->add('fullEvo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageStatusControl::class,
        ]);
    }
}
