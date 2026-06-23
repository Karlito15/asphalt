<?php

declare(strict_types=1);

namespace App\Domain\Form;

use App\Domain\Entity\GarageStatus;
use App\Infrastructure\Abstract\Form\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatusType extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('unblock', CheckboxType::class, [
//                'attr'          => self::attrClass(),
                'label'         => 'form.unblock',
                'label_attr'    => self::attrLabel(),
                'required'      => false,
            ])
            ->add('gold', CheckboxType::class, [
//                'attr'          => self::attrClass(),
                'label'         => 'form.gold',
                'label_attr'    => self::attrLabel(),
                'required'      => false,
            ])
            ->add('toUpgrade', CheckboxType::class, [
//                'attr'          => self::attrClass(),
                'label'         => 'form.to.upgrade',
                'label_attr'    => self::attrLabel(),
                'required'      => false,
            ])
            ->add('evo', CheckboxType::class, [
//                'attr'          => self::attrClass(),
                'label'         => 'form.evo',
                'label_attr'    => self::attrLabel(),
                'required'      => false,
            ])
            ->add('eventClass', CheckboxType::class, [
//                'attr'          => self::attrClass(),
                'label'         => 'form.event.class',
                'label_attr'    => self::attrLabel(),
                'required'      => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageStatus::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'forms',//messages
        ]);
    }

//    /** PRIVATE METHODS */
//
//    /**
//     * @return array
//     */
//    private static function attrClass(): array
//    {
//        return [
//            'class' => 'btn-check'//form-check-input
//        ];
//    }
//
}
