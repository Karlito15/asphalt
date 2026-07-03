<?php

declare(strict_types=1);

namespace App\Domain\Form;

use App\Domain\Entity\GarageStatusControl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatusControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('toInstallSpeed', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.speed',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullSpeed', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.speed',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toInstallAcceleration', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.acceleration',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullAcceleration', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.acceleration',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toInstallHandling', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.handling',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullHandling', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.handling',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toInstallNitro', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.nitro',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullNitro', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.nitro',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toInstallCommon', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.common',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullCommon', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.common',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toInstallRare', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.rare',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullRare', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.rare',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toInstallEpic', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.epic',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullEpic', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.epic',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullStar1', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.star.1',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullStar2', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.star.2',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullStar3', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.star.3',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullStar4', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.star.4',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullStar5', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.star.5',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullStar6', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.star.6',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullBlueprint', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.blueprint',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toInstallUpgrade', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.upgrade',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullUpgrade', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.upgrade',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toInstallImport', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.install.import',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullImport', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.import',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('toGold', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.to.gold',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
            ->add('fullEvo', CheckboxType::class, [
                'attr'          => self::attrClassPrivate(),
                'label'         => 'form.full.evo',
                'label_attr'    => self::attrLabelPrivate(),
                'required'      => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageStatusControl::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'forms',
        ]);
    }

    /** PRIVATE METHODS */

    /**
     * @return array
     */
    private static function attrClassPrivate(): array
    {
        return [
            'class' => 'btn-check'
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function attrLabelPrivate(): array
    {
        return [
            'class' => 'btn btn-outline-info w-100',
        ];
    }
}
